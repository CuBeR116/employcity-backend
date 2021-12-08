<?php

namespace App\Parser\Service;

use App\Kernel;
use App\News\Entity\NewsEntity;

class ParserService
{
    public function startParse()
    {
        $dependect = (new Kernel(NewsEntity::class, true))->getContainer();
    }
}
