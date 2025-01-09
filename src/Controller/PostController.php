<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Entreprise;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('company/post/new', name: 'post_new')] 
    public function new(Request $request, EntityManagerInterface $entityManager): Response 
    { 
        $post = new Post();
        $form = $this->createForm(PostType::class, $post); 

        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) { 
            // Récupérer l'entreprise sélectionnée dans le formulaire 
            $entreprise = $this->getUser()->getEntreprise(); 

            if ($entreprise) { 
                $post->setEntreprise($entreprise); 
                $entityManager->persist($post); 
                $entityManager->flush(); 

                return $this->redirectToRoute('post_success'); 
            } 
            else { 
                // Gérer le cas où l'entreprise n'est pas trouvée 
                $this->addFlash('error', 'Entreprise non trouvée.'); 
            } 
        } 

        return $this->render('post/new.html.twig', [ 
            'form' => $form->createView(), 
        ]); 
    }

    #[Route('company/post/edit/{id}', name: 'post_edit')]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('post_success');
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form->createView(),
            'post' => $post,
        ]);
    }

    #[Route('company/post/success', name: 'post_success')]
    public function success(): Response
    {
        return $this->render('post/success.html.twig');
    }

    #[Route('company/post', name: 'post_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $posts = $entityManager->getRepository(Post::class)->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('company/post/delete/{id}', name: 'post_delete')]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
    #[Route('company/post/{id}', name: 'page_post')] 
    public function show(Post $post): Response 
    { 
        return $this->render('post/show.html.twig', [ 
            'post' => $post, 
        ]);
     }
} 
