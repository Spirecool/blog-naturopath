<?php

namespace App\Controller\Blog;

use App\Repository\Post\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/blog', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        //1ère méthode
        // $posts = $postRepository->findBy(
        //     ['state' => 'STATE_PUBLISHED'],
        //     ['createdAt' => "ASC"]
        // );

        //2nde méthode
        $posts = $postRepository->findPublished();

        return $this->render('pages/blog/index.html.twig', [
            'posts' => $posts
        ]);
    }
}
