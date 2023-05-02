<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Event\UsersCreatedEvent;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_admin_user_index',methods:['GET'])]
    public function index(UsersRepository $usersRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_admin_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UsersRepository $usersRepository, EventDispatcherInterface $dispatcher): Response
    {
        $user = new Users();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $event = new UsersCreatedEvent($user);
            $dispatcher->dispatch($event, UsersCreatedEvent::NAME);

            $usersRepository->save($user, true);

            return $this->redirectToRoute('app_admin_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'user' => $user,
            'userForm' => $userForm,
        ]);
    }
}
