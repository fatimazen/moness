<?php

namespace App\Controller;

use App\Repository\ArticlespresseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlespresseController extends AbstractController
{
    #[Route('/news', name: 'articlespresse.index')]
    // #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ArticlespresseRepository $articlespresseRepository): Response
    {
        $articlespresses = $articlespresseRepository->findPublished();


        return $this->render('articlespresse/index.html.twig', [
            'controller_name' => 'ArticlespresseController',
            'articlespresses' => $articlespresses
        ]);
    }
}
