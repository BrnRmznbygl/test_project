<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DevelopperRepository;
class EntrepriseController extends AbstractController
{
    #[Route('/company/home', name: 'company_home')]
    public function companyHome(DevelopperRepository $developerRepo,EntrepriseRepository $entrepriseRepository): Response
    {
        $user = $this->getUser();
        $entreprise = $entrepriseRepository->findOneBy(['UserEntreprise' => $user]);

        // Récupérer les profils les plus consultés et les derniers profils créés
        $mostViewedProfiles = $developerRepo->findMostViewedProfiles(5);
        $latestProfiles = $developerRepo->findLatestProfiles(3);

        return $this->render('home/company_home.html.twig', [
            'entreprise' => $entreprise,
            'mostViewedProfiles' => $mostViewedProfiles,
            'latestProfiles' => $latestProfiles,
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
