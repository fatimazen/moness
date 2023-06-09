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

    public function getEssData(EntityManagerInterface $entityManager, EssRepository $essRepository, Request $request): JsonResponse
    {
        // on recupere les coordonnée rentrer et la distance maximal
        $latitude = $request->query->get('latitude');
        $longitude = $request->query->get('longitude');
        $distanceMax = $request->query->get('distance');

        // Récupérer les données ESS avec les informations de géolocalisation
        $essData = $essRepository->findAll();

        // Formatage des données pour la réponse JSON
        $bldgData = [];
        foreach ($essData as $ess) {
            $geoLocalisation = $ess->getGeoLocalisationEss();

            // Vérifier si la géolocalisation existe pour l'ESS
            if ($geoLocalisation !== null) {

                $distance = $this->distance(
                    $latitude,
                    $longitude,
                    $geoLocalisation->getLatitude(),
                    $geoLocalisation->getLongitude()
                );
                if($distance < $distanceMax ){

                    // Ajouter les informations de géolocalisation à la réponse JSON
                    $bldgData[] = [
                        'latitude' => $geoLocalisation->getLatitude(),
                        'longitude' => $geoLocalisation->getLongitude(),
                        'nameStructure' => $ess->getNameStructure(),
                        'city' => $ess->getCity(),
                        'zipCode' => $ess->getZipCode(),
                        'sectorActivity' => $ess->getSectorActivity(),
                        'activity' => $ess->getActivity(),
                        'adresse' => $ess->getAdress(),
                        // Ajouter d'autres informations que vous souhaitez afficher dans la carte
                        // par exemple : 'nom' => $ess->getNom(), 'description' => $ess->getDescription(), etc.
                    ];

                }
            }
        }
        return new JsonResponse($bldgData);

        // Répondre avec les données 
        return $this->render('home/index.html.twig', [
            // 'bldgData' => json_encode($bldgData[]),
            'essData' => $essData
        ]);
    }
    // permet de calculer la distance entre deux point(d'un point A vers un point B) latitude et longitude
    public function distance($lat1, $lon1, $lat2, $lon2)
    {

        return (6371 *
            acos(
                cos(deg2rad($lat2))
                    * cos(deg2rad($lat1))
                    * cos(deg2rad($lon1) - deg2rad($lon2))
                    + sin(deg2rad($lat2)) * sin(deg2rad($lat1))
            )
        );
    }
}
