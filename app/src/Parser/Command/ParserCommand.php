<?php

namespace App\Parser\Command;

use App\Parser\Service\ParserService;
use Symfony\Component\Console\Command\Command;

class ParserCommand extends Command
{
    protected static $defaultName = 'app:parser:start';
    private ParserService $service;

    public function __construct(ParserService $service)
    {
        parent::__construct();
        $this->service = $service;

        $this->service->startParse();
    }
}