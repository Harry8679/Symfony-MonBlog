<?php

namespace App\Controller;

use DateTime;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $posts = $this->postRepository->findByDateDesc();
        // $posts = $this->postRepository->findAll();
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/posts/{id}', name: 'app_post_show')]
    public function show($id) {
        $post = $this->postRepository->findById($id)[0];
        // dd($post);
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/post/create', name:'app_post_create')]
    public function create(Request $request, EntityManagerInterface $manager) {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Post $post */
            $post = $form->getData();
            $my_date = new DateTime();
            /** @var User $user */
            $user = $this->getUser();

            $post->setCreatedAt($my_date);
            $post->setUser($user);
            

            // dd($post);
            $manager->persist($post);
            $manager->flush();

            $this->addFlash('success', 'Post created successfully !');

            return $this->redirectToRoute('app_post');
        }

        return $this->render('post/create.html.twig', [
            'formPost' => $form
        ]);
    }
}
