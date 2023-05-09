<?php

namespace App\Controller\Admin;

use App\Repository\EssRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EssController extends AbstractController
{
    #[Route('/admin/ess', name: 'app_admin_ess')]
    public function index(EssRepository $repository,  PaginatorInterface $paginator, Request $request): Response

    {
        $essS= $paginator->paginate(
            $repository ->findAll(),
            $request->query->getInt('page', 1), 
            10 
        );
        
        


        return $this->render('admin/ess/index.html.twig', [
            'essS'=> $essS
        ]);
    }
}
