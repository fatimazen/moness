<?php

namespace App\Controller;

use App\Repository\EssRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    /**
     * @Route("/getEssData", name="get_ess_data", methods={"GET"})
     */
    
    public function getEssData( EntityManagerInterface $entityManager, EssRepository $essRepository,Request $request): array
    {
        // Récupérer les données ESS avec les informations de géolocalisation
        $essData = $essRepository->findAll();

        // Formatage des données pour la réponse JSON
        $bldgData = [];
        foreach ($essData as $ess) {
            $geoLocalisation = $ess->getGeoLocalisationEss();
            
            // Vérifier si la géolocalisation existe pour l'ESS
            if ($geoLocalisation !== null) {
                // Ajouter les informations de géolocalisation à la réponse JSON
                $bldgData[] = [
                    'latitude' => $geoLocalisation->getLatitude(),
                    'longitude' => $geoLocalisation->getLongitude(),
                    // Ajouter d'autres informations que vous souhaitez afficher dans la carte
                    // par exemple : 'nom' => $ess->getNom(), 'description' => $ess->getDescription(), etc.
                ];
                return $bldgData;
            }
        }

        // Répondre avec les données 
        return $this->render('home/index.html.twig', [
            'bldgData' => json_encode($bldgData),         ]);    }
}