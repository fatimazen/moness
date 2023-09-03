<?php

namespace App\Controller;

use App\Entity\Ess;
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
        // $ess = $user->getEss();

        // $essS = $repository->findBy(['users' => $user]);


        return $this->render('ess/index.html.twig', [
            'user' => $user,
            // 'ess' => $ess,
            // 'essS' => $essS
        ]);
    }
    /**
     * fonction qui permet d ajouter une ess
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
    /**
     * fonction qui permet de modifier une ess
     */
    #[Route('/ess/edit/{id}', name: 'ess.edit', methods: ['GET', 'POST'])]
    public function edit(EssRepository $essRepository, int $id, UsersRepository $usersRepository, Request $request): Response
    {
        $user = $this->getUser();
        // $user = $usersRepository->findAll($essRepository);
        $ess = $essRepository->findOneBy(["id" => $id]);


        $essForm = $this->createForm(EssFormType::class, $ess);
        $essForm->handleRequest($request);
        
        if ($essForm->isSubmitted() && $essForm->isValid()) {
            // Récupérer les valeurs des nouveaux champs "Ville", "Adresse" et "Code postal"sont récupérées à partir du formulaire et ensuite affectées à l'entité Ess.
            $city = $essForm->get('city')->getData();
            $adress = $essForm->get('adress')->getData();
            $zipCode = $essForm->get('zipCode')->getData();

            // Faites ce que vous souhaitez avec ces valeurs (par exemple, mettez à jour l'entité Ess)
            $ess->setCity($city);
            $ess->setAdress($adress);
            $ess->setZipCode($zipCode);

            $essRepository->save($ess, true);

            return $this->redirectToRoute('ess.index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('ess/edit.html.twig', [
            'ess' => $ess,
            'essForm' => $essForm,
            'user' => $user
        ]);
    }
    /**
     * fonction qui permet de supprimer une ess
     */
    #[Route('/ess/supprimer-compte/{id}', name: 'ess.delete', methods: ['GET'])]
    public function delete(Request $request, Ess $ess, EntityManagerInterface $manager): Response
    {

        // Supprimer l'utilisateur
        $manager->remove($ess);
        $manager->flush();

        $this->addFlash('success', 'Votre compte a bien été supprimé');


        return $this->redirectToRoute('ess.index');
    }
}
