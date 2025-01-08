<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    #[Route('/post/{id}', name: 'page_post')]
    public function index(int $id, PostRepository $postRepository, EntityManagerInterface $entityManager): Response
    {
        $post = $postRepository->find($id);
        if($post->getEntreprise() !== $this->getUser()->getEntreprise()) {
            $post->incrementViews();
            $entityManager->flush();
        }

        if(!$post) {
            throw $this->createNotFoundException('Post not found');
        }


        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'post' => $post,
        ]);
    }
}
