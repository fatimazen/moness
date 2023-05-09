<?php

namespace App\Controller\Admin;

use App\Repository\EssRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EssController extends AbstractController
{
    #[Route('/admin/ess', name: 'app_admin_ess')]
    public function index(EssRepository $repository): Response

    {
        $essS =$repository ->findAll();


        return $this->render('admin/ess/index.html.twig', [
            'essS'=> $essS
        ]);
    }
}
