<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EntrepriseController extends AbstractController
{
    #[Route('/profile/entreprise/{id}', name: 'entreprise_profile')]
    public function show(int $id, EntrepriseRepository $repository): Response
    {
        // Récupérer les développeurs les plus consultés
        $mostViewedDeveloppers = $developperRepository->findMostViewedProfiles();

        // Récupérer les derniers développeurs créés
        $latestDeveloppers = $developperRepository->findLatestProfiles();
  
        return $this->render('entreprise/home.html.twig', [
              'mostViewedDeveloppers' => $mostViewedDeveloppers,
              'latestDeveloppers' => $latestDeveloppers,
        ]);
    }

    #[Route('/company/serialize', name: 'company_serialize')]
    public function serialize(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('You must be logged in to extract this profile.');
        }

        $entreprise = $user->getEntreprise();
        return $this->json($entreprise);
    }
}
