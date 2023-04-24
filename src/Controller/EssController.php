<?php

namespace App\Controller;

use App\Entity\Ess;
use App\Form\EssFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EssController extends AbstractController
{
    #[Route('/ajoutEss', name: 'app_ess')]
    public function add(): Response
    {
        // je crée une nouvelle structure ess
        $ess= new Ess();
        // on créér le formulaire
        $essForm=$this->createForm(EssFormType::class, $ess);

        return $this->render('ess/add.html.twig', [
            'controller_name' => 'EssController',
            'essForm' => $essForm->createView()
        ]);
    }
}
