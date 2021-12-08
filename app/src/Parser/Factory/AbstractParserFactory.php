<?php

namespace App\Parser\Factory;

use App\Parser\Entity\ParserEntity;

abstract class AbstractParserFactory
{
    protected ParserEntity $parser;

    public function __construct(ParserEntity $parser)
    {
        $this->parser = $parser;
    }

    abstract public function startParse();
}
