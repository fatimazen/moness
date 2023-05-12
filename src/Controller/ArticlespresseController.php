<?php

namespace App\Controller;

use App\Repository\ArticlespresseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/news', name: 'app_articlespresse')]
class ArticlespresseController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ArticlespresseRepository $articlespresseRepository): Response
    {
        $articlespresses = $articlespresseRepository->findPublished();
    

        return $this->render('articlespresse/index.html.twig', [
            'controller_name' => 'ArticlespresseController',
             'articlespresses' => $articlespresses
        ]);
    }
}
