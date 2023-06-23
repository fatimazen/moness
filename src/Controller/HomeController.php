<?php


namespace App\Controller;

use App\Controller\MapController;
use App\Repository\EssRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{
    private $mapController;

    public function __construct(MapController $mapController)
{
    $this->mapController = $mapController;
}
    #[Route('/', name: 'home.index')]
    public function index(Request $request, EntityManagerInterface $entityManager, EssRepository $essRepository): Response
    {
    
        $essData = $this->mapController->getEssData($entityManager, $essRepository, $request);
         $essData = new JsonResponse($essData);
         
        return $this->render('home/index.html.twig', [
            'essData' => $essData->getContent(),

        ]);
    }
}
