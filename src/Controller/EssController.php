<?php

namespace App\Controller;

use App\Entity\Ess;
use App\Entity\Users;
use App\Form\EssType;
use App\Form\EssFormType;
use App\Repository\EssRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

class EssController extends AbstractController
{
    /**
     * fonction qui permet afficher toutes les ess des utilisateurs connecter
     *
     * @param EssRepository $repository
     * @return Response
     */
    #[Route('/ess', name: 'ess.index')]
    public function index(EssRepository $repository): Response
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $this->getUser();

        // Récupérer la collection d'ess associés à l'utilisateur
        $ess = $user->getEss();

        $essS = $repository->findBy(['users' => $user]);

        return $this->render('ess/index.html.twig', [
            'user' => $user,
            'ess' => $ess,
            'essS' => $essS
        ]);
    }
    /**
     * fonction qui permet 
     *
     * @param Request $request
     * @param UsersRepository $usersRepository
     * @param EntityManagerInterface $manager
     * @param ValidatorInterface $validator
     * @param UploaderHelper $uploaderHelper
     * @return Response
     */
    #[Route('/ajoutEss', name: 'app_ess')]
    public function add(Request $request, UsersRepository $usersRepository, EntityManagerInterface $manager, ValidatorInterface $validator, UploaderHelper $uploaderHelper): Response
    {
        // Je crée une nouvelle structure ess
        $ess = new Ess();
        // On créé le formulaire
        $essForm = $this->createForm(EssFormType::class, $ess);

        // On traite la requête du formulaire
        $essForm->handleRequest($request);

        // On vérifie si le formulaire est soumis et valide
        if ($essForm->isSubmitted() && $essForm->isValid()) {
            $user = $this->getUser();
            $ess->setUsers($user);
            $manager->persist($ess);
            $manager->flush();

            // Récupérer le chemin de l'image à partir de l'entité Ess
            $path = $uploaderHelper->asset($ess, 'imageFile');

            $this->addFlash('success', 'Structure ess ajoutée avec succès');
            return $this->redirectToRoute('ess.index');
        }

        return $this->render('ess/add.html.twig', [
            'essForm' => $essForm->createView(),
        ]);
    }

    #[Route('/ess/edit/{id}', name: 'ess.edit', methods: ['GET', 'POST'])]
    public function edit(EssRepository $essRepository, int $id, UsersRepository $usersRepository, Request $request): Response
    {
        $user = $this->getUser();
        $user =$usersRepository->findAll($essRepository);
        $ess = $essRepository->findOneBy(["id" => $id]);


        $essForm = $this->createForm(EssFormType::class, $ess);
        $essForm->handleRequest($request);
        if ($essForm->isSubmitted() && $essForm->isValid()) {

            $essRepository->save($ess, true);

            return $this->redirectToRoute('ess.index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('ess/edit.html.twig', [
            'ess' => $ess,
            'essForm' => $essForm,
            'user'=> $user
        ]);
    }
}
