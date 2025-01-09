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
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/post/new', name: 'post_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entreprise = $this->getUser()->getEntreprise();

            if ($entreprise) {
                $post->setEntreprise($entreprise);
                $entityManager->persist($post);
                $entityManager->flush();

                return $this->redirectToRoute('post_success');
            } else {
                $this->addFlash('error', 'Entreprise non trouvée.');
            }
        }

        return $this->render('post/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/post/edit/{id}', name: 'post_edit')]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        $entreprise = $post->getEntreprise();

        if ($user !== $entreprise->getUserEntreprise()) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à modifier ce post.');
        }

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

    #[Route('/post/success', name: 'post_success')]
    public function success(): Response
    {
        return $this->render('post/success.html.twig');
    }

    #[Route('/post', name: 'post_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $posts = $entityManager->getRepository(Post::class)->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/delete/{id}', name: 'post_delete')]
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $user = $this->security->getUser();
        $entreprise = $post->getEntreprise();

        if ($user !== $entreprise->getUserEntreprise()) {
            throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à supprimer ce post.');
        }

        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }

    #[Route('/post/{id}', name: 'page_post')]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
