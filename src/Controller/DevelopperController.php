<?php

namespace App\Controller;

use App\Entity\Developper;
use App\Form\DevelopperType;
use App\Repository\DevelopperRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DevelopperController extends AbstractController
{
    #[Route('/profile/developper/{id}', name: 'developper_profile')]
    public function show(int $id, DevelopperRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $developper = $repository->find($id);
        if($developper->getUserDevelopper() !== $this->getUser()) {
            $developper->incrementViews();
            $entityManager->flush();
        }

        if (!$developper) {
            throw $this->createNotFoundException('Developper not found');
        }

        return $this->render('profile/developper.html.twig', [
            'developper' => $developper,
        ]);
    }

    #[Route('/developper/edit/{id}', name: 'developper_edit')]
    public function edit(int $id, Request $request, DevelopperRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to edit this profile.');
        }

        $developper = $repository->find($id);

        if (!$developper) {
            throw $this->createNotFoundException('Developper not found');
        }

        if ($developper->getUserDevelopper() !== $user) {
            throw $this->createAccessDeniedException('You do not have permission to edit this profile.');
        }

        $form = $this->createForm(DevelopperType::class, $developper);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $isPublic = $form->get('isPublic')->getData();
            $developper->getUserDevelopper()->setPublic($isPublic);
            $entityManager->flush();


            return $this->redirectToRoute('developper_profile', ['id' => $developper->getId()]);
        }

        return $this->render('developper/edit.html.twig', [
            'form' => $form->createView(),
            'developper' => $developper,
        ]);
    }


    #[Route('/dev/home', name: 'dev_home')]
    public function index(DevelopperRepository $repository): Response
    {
        $user = $this->getUser(); // Get the logged-in user

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to access this page.');
        }

        // Find the Developper entity associated with the logged-in user
        $developper = $repository->findOneBy(['UserDevelopper' => $user]);

        if (!$developper) {
            throw $this->createNotFoundException('No developper profile found for the logged-in user.');
        }

        // Fetch most viewed posts and latest posts (replace with actual logic)
        $mostViewedPosts = []; // Replace with actual logic to fetch most viewed posts
        $latestPosts = []; // Replace with actual logic to fetch latest posts

        // Render the template and pass the developper variable
        return $this->render('/home/dev_home.html.twig', [
            'developper' => $developper,
            'mostViewedPosts' => $mostViewedPosts,
            'latestPosts' => $latestPosts,
        ]);
    }
    #[Route('dev/serialize', name: 'dev_serialize')]
    public function serialize(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to extract this profile.');
        }

        $developper = $user->getDevelopper();
        return $this->json($developper);


    }
}