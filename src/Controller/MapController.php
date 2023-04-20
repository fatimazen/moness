<?php

namespace App\Controller;
use L\Proj\CRS;
use Proj4php\Proj;git pullg
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    #[Route('/map', name: 'app_map')]
    public function index(): Response
    {
        $customCRS = new CRS(
            'EPSG:3006',
            '+proj=utm +zone=33 +ellps=GRS80 +towgs84=0,0,0,0,0,0,0 +units=m +no_defs',
            [
                'resolutions' => [8192, 4096, 2048, 1024, 512, 256, 128],
                'origin' => [0, 0],
            ]
        );

        return $this->render('map/index.html.twig', [
           'customCRS' => ' $customCRS,',
        ]);
    }

}
