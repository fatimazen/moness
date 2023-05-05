<?php

namespace App\Controller;

use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 use Symfony\Component\HttpFoundation\File\File;

#[Route('/blog', name: 'app_blog_')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'index', methods:['GET'])]
    public function index(BlogRepository $blogRepository): Response
    {
        $blog = $blogRepository ->findAll();
        // dd($blog);

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'Blog',
        ]);
    }
}
