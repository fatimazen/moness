<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersFormType;
use App\Service\JWTService;
use App\Service\SendMailService;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class UserInscriptionController extends AbstractController
{
    #[Route('/user/inscription', name: 'app_user_inscription')]
    public function register(Request $request,EntityManagerInterface $entityManager,UserPasswordHasherInterface $userPasswordHasher,UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator): Response
    {
        $user = new Users();
        $userForm = $this->createForm(UsersFormType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $userForm->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
            
        }
        return $this->render('user_inscription/index.html.twig', [
            'controller_name' => 'UserInscriptionController',
            'userForm' => $userForm->createView()
        ]);
    }
    }
