<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Form\UserPasswordType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UsersController extends AbstractController
{
    #[Route('/users', name: 'users.index')]
    public function index()
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $this->getUser();
        // Récupérer la collection d'ess associés à l'utilisateur
        $ess = $user->getEss();

        return $this->render('users/index.html.twig', [
            'user' => $user,
            'ess' => $ess,
        ]);
    }
    /**
     * Ce controller nous permet de modifier le profil de l'utilisateur
     */
    #[Route('/utilisateur/edition/{id}', name: 'users.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Users $user, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('home.index');
        }

        $form = $this->createForm(UsersType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submittedPassword = $form->get('Password')->getData();

            if ($hasher->isPasswordValid($user, $submittedPassword)) {
                $hashedPassword = $hasher->hashPassword($user, $submittedPassword);
                $user->setPassword($hashedPassword);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Les informations de votre compte ont bien été modifiées');

                return $this->redirectToRoute('contact.index');
            } else {
                $this->addFlash('warning', 'Le mot de passe renseigné est incorrect.');
            }
        }

        return $this->render('users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/utilisateur/edition-mot-de-passe/{id}', name: 'users.edit_password', methods: ['GET', 'POST'])]
    public function editPassword(Users $user, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(UserPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement de la modification du mot de passe
            // ...
            //  dd($form->getData());
            if ($hasher->isPasswordValid($user, $form->getData()['password'])) {


                $newPassword = $hasher->hashPassword($user, $form->getData()['newPassword']);
                $user->setPassword($newPassword);

                $manager->persist($user);
                $manager->flush();


                $this->addFlash('success', 'Le mot de passe bien été modifiées');

                // Redirection vers une autre page après modification réussie
                return $this->redirectToRoute('contact.index');
            } else {
                $this->addFlash('warning', 'Le mot de passe renseigné est incorrect.');
            }
        }

        return $this->render('users/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/utilisateur/supprimer-compte/{id}', name: 'users.delete', methods: ['GET'])]
    public function delete(Request $request, Users $user, EntityManagerInterface $manager): Response
    {
        // Vérifier la validité du jeton CSRF

        // Supprimer l'utilisateur
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'Votre compte a bien été supprimé');


        return $this->redirectToRoute('home.index');
    }
}
