<?php

namespace App\Controller;

use App\Entity\Ess;
use App\Form\EssFormType;
use App\Service\PictureService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EssController extends AbstractController
{
    #[Route('/ajoutEss', name: 'app_ess')]
    public function add(Request $request, EntityManagerInterface $em, PictureService $PictureService): Response
    {
        // je crée une nouvelle structure ess
        $ess= new Ess();
        // on créér le formulaire
        $essForm=$this->createForm(EssFormType::class, $ess);

        // on traite la requête du formulaire
        $essForm->handleRequest($request);
        

        // on verifie si le formulaire est soumis et valide 
        if ($essForm->isSubmitted()&& $essForm->isValid())
        {
            // on récupere les images 

            $images =$essForm->get('images')->getData();
            foreach($images as $image){
                // on defini le dossier de destination
                $folder= 'ess';
                // on appelle le service d'ajout
                $fichier=$PictureService ->add($image, $folder, 100, 100);
                

            }
        }



        return $this->render('ess/add.html.twig', [
            'controller_name' => 'EssController',
            'essForm' => $essForm->createView()
        ]);
    }
}
