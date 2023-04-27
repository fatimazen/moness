<?php

namespace App\Controller;

use App\Entity\Ess;
use App\Event\EssCreatedEvent;
use App\Entity\Images;
use App\Form\EssFormType;
use App\Repository\EssRepository;
use App\Service\PictureService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EssController extends AbstractController
{
    #[Route('/ajoutEss', name: 'app_ess')]
    public function add(Request $request,  PictureService $PictureService, EssRepository $essRepository, EventDispatcherInterface $dispatcher): Response
    {
        // Je crée une nouvelle structure ess
        $ess = new Ess();
        // On créé le formulaire
        $essForm = $this->createForm(EssFormType::class, $ess);
    
        // On traite la requête du formulaire
        $essForm->handleRequest($request);

        // On vérifie si le formulaire est soumis et valide
        if ($essForm->isSubmitted() && $essForm->isValid()) {
            // On récupère les images si elles existent
            $images = $essForm->get('images')->getData();
            if (!empty($images)) {
                foreach ($images as $image) {
                    // On définit le dossier de destination
                    $folder = 'ess';
                    // On appelle le service d'ajout
                    $fichier = $PictureService->add($image, $folder, 100, 100);
                    $img = new Images();
                    $img->setName($fichier);
                    $ess->setImages($img);
                }
            }

            $essRepository->save($ess, true);

            $event = new EssCreatedEvent($ess);
            $dispatcher->dispatch($event, EssCreatedEvent::NAME);

            return $this->redirectToRoute('app_ess',[],Response::HTTP_SEE_OTHER);
        }

        return $this->render('ess/add.html.twig', [
            'controller_name' => 'EssController',
            'essForm' => $essForm->createView()
        ]);
    }
}
