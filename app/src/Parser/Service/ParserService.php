<?php

namespace App\Parser\Service;

use App\Entity\News;
use GuzzleHttp\Client;
use PHPHtmlParser\Dom;
use App\Entity\Parser;
use App\Repository\NewsRepository;
use App\Repository\ParserRepository;
use Psr\Http\Message\ResponseInterface;
use App\Parser\Factory\RbcParserFactory;
use App\Parser\Exception\ParserException;
use GuzzleHttp\Exception\GuzzleException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use PHPHtmlParser\Exceptions\StrictException;
use PHPHtmlParser\Exceptions\LogicalException;
use PHPHtmlParser\Exceptions\CircularException;
use PHPHtmlParser\Exceptions\NotLoadedException;
use PHPHtmlParser\Exceptions\ContentLengthException;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ParserService
{
    private ParserRepository $repository;
    private ManagerRegistry $registry;

    public function __construct(ParserRepository $repository, ManagerRegistry $registry)
    {
        $this->repository = $repository;
        $this->registry = $registry;
    }

    /**
     * @throws GuzzleException
     * @throws ParserException
     * @throws ChildNotFoundException
     * @throws CircularException
     * @throws ContentLengthException
     * @throws LogicalException
     * @throws NotLoadedException
     * @throws StrictException
     * @throws NonUniqueResultException
     */
    public function startParse()
    {
        $manager = $this->registry->getManager();

        //Получить все парсеры
        $parserCollection = $this->repository->findAll();
        if (!$parserCollection) {
            throw new ParserException('Список парсеров не был найден');
        }
        foreach ($parserCollection as $parser) {
            $response = $this->getSiteContent('http://' . $parser->getSite());

            $dom = new Dom();
            $dom->loadStr($response->getBody());
            $items = $dom->find($parser->getItemNode());
            if (!$items->count()) {
                continue;
            }

            /** @var Dom\Node\HtmlNode $item */
            foreach ($items as $item) {
                $factory = $this->getFactory($item, $parser);
                $factory->initNews();

                $link = $factory->getDetailLink();
                $detail = $this->getSiteContent($link);

                $detailDom = new Dom();
                $detailDom->loadStr($detail->getBody());
                $news = $factory->getNews();
                $textNode = $detailDom->find($parser->getDetailNode())[0];
                if (!$textNode) {
                    dump(sprintf('Контент не удалось найти по ссылки %s', $link));
                    continue;
                }

                $news->setText($textNode->innerHtml());

                $manager->persist($news);

                try {
                    $manager->flush();
                } catch (UniqueConstraintViolationException $e) {
                    dd($news, $e);
                }
            }
        }
    }

    /**
     * @param Dom\Node\HtmlNode $item
     * @param Parser $parser
     *
     * @throws ParserException
     * @return RbcParserFactory
     */
    private function getFactory(Dom\Node\HtmlNode $item, Parser $parser): RbcParserFactory
    {
        /** @var NewsRepository $newsRepository */
        $newsRepository = $this->registry->getRepository(News::class);
        //Придумать лучше способ, как получать другие фабрики
        $factories[] = new RbcParserFactory($item, $parser, $newsRepository);

        foreach ($factories as $factory) {
            if ($factory->getSite() === $parser->getSite()) {
                return $factory;
            }
        }

        throw new ParserException('Не найдена фабрика');
    }

    /**
     * @param string $url
     *
     * @throws GuzzleException
     * @return ResponseInterface
     */
    private function getSiteContent(string $url): ResponseInterface
    {
        $client = new Client();

        return $client->request('GET', $url);
    }
}
