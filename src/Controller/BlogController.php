<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsFormType;
use App\Repository\BlogRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog.index')]
    // #[Route('/', name: 'index', methods:['GET'])]
    public function index(BlogRepository $blogRepository, Request $request): Response
    {
        $articleBlogs = $blogRepository->findPublished($request->query->getInt('page',1));
       


        return $this->render('blog/index.html.twig', [
            'articleBlogs' => $articleBlogs,
        ]);
    }

    #[Route('/blog/{id}', name: 'blog.show')]
    public function show(BlogRepository $blogRepository, int $id, Request $request, EntityManagerInterface $manager): Response
    {

        $blog = $blogRepository->findOneBy(["id" => $id]);

        $comment = new Comments();
        $form = $this->createForm(CommentsFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setBlog($blog);
            $user = $this->getUser();
            $comment->setAuthor($user);
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Votre commentaire à bien été enregistré il sera soumis a modération très rapidement');
            return $this->redirectToRoute('blog.show', [
                "id" => $id,
            ]);
        }
        return $this->render('blog/show.html.twig', [
            'articleBlog' => $blog,
            'form' => $form->createView(),
        ]);
    }
    
}
