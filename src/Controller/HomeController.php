<?php


namespace App\Controller;

use App\Controller\MapController;
use App\Entity\Ess;
use App\Repository\EssRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends AbstractController
{

    #[Route('/', name: 'home.index')]
    public function index(Request $request, EntityManagerInterface $entityManager, EssRepository $essRepository): Response
    {
        $companies = $essRepository->findAll();
        $companies = array_filter($companies, function (Ess $ess) {
            return !empty($ess->getGeoLocalisationEss());
        });

        $companies = array_values(array_map(function (Ess $ess) {
            return [
                'latitude' => $ess->getGeoLocalisationEss()->getLatitude(),
                'longitude' => $ess->getGeoLocalisationEss()->getLongitude(),
                'name' => $ess->getNameStructure(),
                'adress' => $ess->getAdress(),
                'description' => $ess->getDescription(),
            ];
        }, $companies));

        return $this->render('home/index.html.twig', [
            'companies' => $companies
        ]);
    }
}
