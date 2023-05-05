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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EssController extends AbstractController
{
    #[Route('/ess', name: 'app_ess_index')]
    public function index(): Response
    {
        return $this->render('ess/index.html.twig', [
            'controller_name' => 'EssController',
        ]);
    }
    #[Route('/ajoutEss', name: 'app_ess')]

    public function add(Request $request, EssRepository $essRepository, EntityManagerInterface $manager, ValidatorInterface $validator): Response

    {
        // Je crée une nouvelle structure ess
        $ess = new Ess();
        // On créé le formulaire
        $essForm = $this->createForm(EssFormType::class, $ess);

        // On traite la requête du formulaire
        $essForm->handleRequest($request);


        // On vérifie si le formulaire est soumis et valide
        if ($essForm->isSubmitted() && $essForm->isValid()) {




            // $essRepository->save($ess, true);


            $manager->persist($ess);
            $manager->flush();
            $this->addFlash('sucess', 'structure ess ajouté avec succès');
            return $this->redirectToRoute('app_ess_index');



            return $this->redirectToRoute('app_ess', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ess/add.html.twig', [
            'controller_name' => 'EssController',
            'essForm' => $essForm->createView()
        ]);
    }
}
