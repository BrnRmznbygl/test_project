<?php
namespace App\Controller;

use App\Entity\Post;
use App\Form\MatchingFormType;
use App\Repository\DevelopperRepository;
use App\Service\MatchingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchingController extends AbstractController
{
    #[Route('/post/{id}/matching', name: 'post_matching')]
    public function match(
        Post $post,
        DevelopperRepository $developperRepository,
        MatchingService $matchingService,
        Request $request
    ): Response {
        $developers = $developperRepository->findAll();

        // Création du formulaire
        $form = $this->createForm(MatchingFormType::class);
        $form->handleRequest($request);

        $minScore = 3; // Score par défaut
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $minScore = $data['minScore']; // Récupération du score minimum
        }

        $matches = $matchingService->matchDevelopersToPost($developers, $post, $minScore);

        return $this->render('matching/match.html.twig', [
            'post' => $post,
            'matches' => $matches,
            'minScore' => $minScore,
            'form' => $form->createView(),
        ]);
    }
}
