<?php

namespace App\Controller;

use App\Entity\Users;
use App\Event\UsersCreatedEvent;
use App\Form\UsersFormType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserInscriptionController extends AbstractController
{
    #[Route('/user/inscription', name: 'app_user_inscription')]
    public function index(Request $request, UsersRepository $userRepository, EventDispatcherInterface $dispatcher): Response
    {
        // Je crée une nouvelle structure ess
        $user = new Users();
        // On créé le formulaire
        $userForm = $this->createForm(UsersFormType::class, $user);

        // On traite la requête du formulaire
        $userForm->handleRequest($request);

        // On vérifie si le formulaire est soumis et valide
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $userRepository->save($user, true);

            $event = new UsersCreatedEvent($user);
            $dispatcher->dispatch($event, UsersCreatedEvent::NAME);

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user_inscription/index.html.twig', [
            'controller_name' => 'UserInscriptionController',
            'userForm' => $userForm->createView()
        ]);
    }
}
