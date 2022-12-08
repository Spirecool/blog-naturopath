<?php

namespace App\Controller\Blog;

use App\Entity\Post\Post;
use App\Repository\Post\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    #[Route('/blog', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, Request $request): Response
    {
        //1ère méthode
        // $posts = $postRepository->findBy(
        //     ['state' => 'STATE_PUBLISHED'],
        //     ['createdAt' => "ASC"]
        // );

        //2nde méthode
        $posts = $postRepository->findPublished($request->query->getInt('page', 1));
                  
        return $this->render('pages/blog/index.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route('/article/{slug}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('pages/blog/show.html.twig', [
            'post' => $post
        ]);
    }

}
