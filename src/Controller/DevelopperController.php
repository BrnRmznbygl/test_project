<?php

namespace App\Controller;

use App\Entity\Developper;
use App\Form\DevelopperType;
use App\Repository\DevelopperRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DevelopperController extends AbstractController
{
    #[Route('/profile/developper/{id}', name: 'developper_profile')]
    public function show(int $id, DevelopperRepository $repository): Response
    {
        $developper = $repository->find($id);

        if (!$developper) {
            throw $this->createNotFoundException('Developper not found');
        }

        return $this->render('profile/developper.html.twig', [
            'developper' => $developper,
        ]);
    }

    #[Route('/developper/edit/{id}', name: 'developper_edit')]
    public function edit(Request $request, Developper $developper, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DevelopperType::class, $developper);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
        // Fetch the developper entity from the database
        $developper = $repository->find(1); // Replace 1 with the appropriate ID

        // Check if the developper entity was found
        if (!$developper) {
            throw $this->createNotFoundException('No developper found for id 1');
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
}