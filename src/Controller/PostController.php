<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    
    #[Route('/posts', name: 'app_post')]
    public function index(): Response
    {
        $posts = $this->postRepository->findAll();
        dd($posts);
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/posts/{id}', name: 'app_post_show')]
    public function show($id) {
        $post = $this->postRepository->findById($id);
        dd($post);
    }
}
