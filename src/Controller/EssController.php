<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EssController extends AbstractController
{
    #[Route('/Ess', name: 'app_ess')]
    public function index(): Response
    {
        return $this->render('Ess/index.html.twig', [
            'controller_name' => 'EssController',
        ]);
    }
}
