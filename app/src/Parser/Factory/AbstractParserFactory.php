<?php

namespace App\Parser\Factory;

use App\Entity\News;
use App\Entity\Parser;
use DateTimeImmutable;
use App\Entity\NewsParser;
use App\Repository\NewsRepository;
use PHPHtmlParser\Dom\Node\HtmlNode;
use App\Parser\Exception\ParserException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\String\Slugger\AsciiSlugger;
use PHPHtmlParser\Exceptions\ChildNotFoundException;

abstract class AbstractParserFactory
{
    protected Parser $parser;
    protected HtmlNode $node;
    protected NewsRepository $repository;

    protected News $news;
    protected string $site = '';

    public function __construct(HtmlNode $node, Parser $parser, NewsRepository $repository)
    {
        $this->parser = $parser;
        $this->node = $node;
        $this->repository = $repository;
    }

    public function getSite(): string
    {
        return $this->site;
    }

    /**
     * @throws ParserException
     * @throws ChildNotFoundException
     * @throws NonUniqueResultException
     */
    public function initNews()
    {
        $news = new News();
        $newsParser = new NewsParser();

        /** @var HtmlNode $nameNode */
        $nameNode = $this->node->find($this->parser->getNameNode())[0];
        if (!$nameNode) {
            throw new ParserException('Название не найдено');
        }
        $name = trim($nameNode->innerhtml);
        $s = new AsciiSlugger('ru');
        $slug = $s->slug($name)->lower();

        $exists = $this->repository->findBySlug($slug);
        if ($exists) {
            $news = $exists;
        }

        $news->setName($name);

        $news->setSlug($slug);

        //Изменить реализация, и спарсить данные с HtmlNode
        $news->setCreatedAt(new DateTimeImmutable());

        $newsParser->setNews($news);
        $newsParser->setParser($this->parser);

        $news->setNewsParser($newsParser);

        $this->news = $news;
    }

    public function getNews(): News
    {
        return $this->news;
    }
}
