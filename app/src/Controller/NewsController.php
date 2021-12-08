<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'news', methods: 'get')]
    public function index(ManagerRegistry $doctrine): Response
    {
        dump($doctrine->getManager());
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/NewsController.php',
        ]);
    }
}
