<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsFormType;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticlespresseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlespresseController extends AbstractController
{
    #[Route('/news', name: 'articlespresse.index')]
    // #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ArticlespresseRepository $articlespresseRepository,Request $request): Response
    {
        $articlespresses = $articlespresseRepository->findPublished($request->query->getInt('page',1));


        return $this->render('articlespresse/index.html.twig', [
            'articlespresses' => $articlespresses
        ]);
    }
    #[Route('/news/{id}', name: 'articlespresse.show')]
    public function show(ArticlespresseRepository $articlespresseRepository, int $id, Request $request, EntityManagerInterface $manager): Response
    {
        $articlespresse = $articlespresseRepository->findOneBy(["id" => $id]);

        $comment = new Comments();
        $form = $this->createForm(CommentsFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setArticlepresse($articlespresse);
            $user = $this->getUser();
            $comment->setAuthor($user);
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Votre commentaire à bien été enregistré il sera soumis a modération très rapidement');
            return $this->redirectToRoute('articlespresse.show', [
                "id" => $id,
            ]);
        }

        return $this->render('articlespresse/show.html.twig', [
            'articlePresse' => $articlespresse,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/comments/{id}', name: 'comments.delete', methods: ['POST'])]
    public function delete(Request $request, Comments $comments, CommentsRepository $commentsRepository): Response
    {

        return $this->redirectToRoute('articlespresse/_form.html.twig', []);
    }
}
