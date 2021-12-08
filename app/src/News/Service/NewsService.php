<?php

namespace App\News\Service;

use App\News\Entity\NewsEntity;
use Doctrine\ORM\EntityManagerInterface;

class NewsService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }

    public function addNews(NewsEntity $newsEntity)
    {
        $this->entityManager->persist($newsEntity);
        $this->entityManager->flush();
    }
}
