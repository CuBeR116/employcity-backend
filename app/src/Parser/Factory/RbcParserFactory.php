<?php

namespace App\Parser\Factory;

use App\Entity\News;
use App\Entity\NewsParser;
use PHPHtmlParser\Dom\Node\HtmlNode;
use App\Parser\Exception\ParserException;
use Symfony\Component\String\Slugger\AsciiSlugger;
use PHPHtmlParser\Exceptions\ChildNotFoundException;
use PHPHtmlParser\Exceptions\UnknownChildTypeException;

class RbcParserFactory extends AbstractParserFactory
{
    protected string $site = 'rbk.ru';

    /**
     * @throws ChildNotFoundException
     * @throws ParserException
     * @return string
     */
    public function getDetailLink(): string
    {
        $linkNode = $this->node->find($this->parser->getLinkNode())[0];
        if (!$linkNode && $this->node->getAttribute('href')) {
            $linkNode = $this->node;
        }

        if (!$linkNode) {
            throw new ParserException('Ссылка не найдена');
        }

        return $linkNode->getAttribute('href');
    }
}
