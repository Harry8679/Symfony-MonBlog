<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manger)
    {
        $this->manager = $manger;
    }
    
    #[Route('/register', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $encode): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Entity\User $user */
            $user = $form->getData();

            // dd($user->getPassword());
            $hashed_password = $encode->hashPassword($user, $user->getPassword());
            // dd($hashed_password);
            $user->setPassword($hashed_password);
            
            $this->manager->persist($user);
            $this->manager->flush();

            $this->addFlash('success', 'Your account is created successfully !');

            return $this->redirectToRoute('app_home_page');
        }
        return $this->render('register/index.html.twig', [
            'formRegister' => $form,
        ]);
    }
}
