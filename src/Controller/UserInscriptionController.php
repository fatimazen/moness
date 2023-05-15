<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersFormType;
use App\Service\JWTService;
use App\Service\MailerService;
use App\Service\SendMailService;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Exception\AccessException;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException as ExceptionAccessDeniedException;

class UserInscriptionController extends AbstractController
{
    #[Route('/user/inscription', name: 'user_inscription.index')]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, MailerService $mailerService, TokenGeneratorInterface $tokenGeneratorInterface): Response
    {
        $user = new Users();
        $userForm = $this->createForm(UsersFormType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            // token

            $tokenRegistration = $tokenGeneratorInterface->generateToken();
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $userForm->get('plainPassword')->getData()
                )
            );
            // user token
            $user->setTokenRegistration($tokenRegistration);


            $entityManager->persist($user);
            $entityManager->flush();

            // creer mail
            $mailerService->send(
                $user->getEmail(),
                'configuration du compte utilisateur',
                'registration_confirmation.html.twig',
                [
                    'user' => $user,
                    'token' => $tokenRegistration,
                    'lifeTimeToken' => $user->getTokenRegistrationLifeTime()->format('d-m-Y H:i:s')
                ]
            );

            $this->addFlash('success', 'Votre compte à bien été créé, veuillez vérifier vos e-mails pour l\'activer.');
            return $this->redirectToRoute('app_login');

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
    #[Route('/verify/{token}/{id<\d+>}', name: 'account_verify', methods: ['GET'])]
    public function verify(string $token, Users $user, EntityManagerInterface $manager): Response
    {

        if ($user->getTokenRegistration() !== $token) {
            throw new AccessDeniedException();
        }
        if ($user->getTokenRegistration() === null) {
            throw new AccessDeniedException();
        }
        if (new DateTime('now') > $user->getTokenRegistrationLifeTime()) {
            throw new AccessException();
        }

        $user->setIsVerfied(true);
        $user->setTokenRegistration(null);
        $manager->flush();

        $this->addFlash('success', 'Votre compte a bien été activé, vous pouvez maintenant vous connecter .');

        return $this->redirectToRoute('app_login');
    }
}
