<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends AbstractController
{
/**
 * Ce controller nous permet de mofifier le profil de utilisateur
 * 
 */

    #[Route('/utilisateur/edition/{id}', name: 'users.edit',methods:['GET', 'POST'])]
    public function edit(Request $request, Users $user,EntityManagerInterface $manger): Response
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

        $usersForm = $this->createForm(UsersType::class, $user);

        $usersForm->handleRequest($request);
        if($usersForm->isSubmitted() && $usersForm->isValid()){
            $user = $usersForm->getData();
            $manger->persist($user);
            $manger->flush();

            $this->addFlash('success', 'les informations de votre compte ont bien été modifiées');

            return $this->redirectToRoute('home.index');

        }

        return $this->render('users/edit.html.twig', [
            'usersForm' => $usersForm->createView(),
        ]);
    }
}
