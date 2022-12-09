<?php

namespace App\Controller\Blog;

use App\Entity\Post\Post;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\Post\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    #[Route('/blog', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, Request $request): Response
    {
        // Formulaire de recherche dans le contrôleur
        $searchData =  new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $posts = $postRepository->findBySearch($searchData);

            return $this->render('pages/blog/index.html.twig', [
                'form' => $form->createView(),
                'posts' => $posts
            ]);
        }

        //1ère méthode
        // $posts = $postRepository->findBy(
        //     ['state' => 'STATE_PUBLISHED'],
        //     ['createdAt' => "ASC"]
        // );

        //2nde méthode
        $posts = $postRepository->findPublished($request->query->getInt('page', 1));

        return $this->render('pages/blog/index.html.twig', [
            'form' => $form->createView(),
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
