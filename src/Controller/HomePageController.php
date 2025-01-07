<?php

namespace App\Controller;

use App\Repository\DevelopperRepository;
use App\Repository\JobPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Vérifie si l'utilisateur est connecté
        $user = $this->getUser();

        if ($user) {
            // Redirige en fonction du rôle
            if ($this->isGranted('ROLE_COMPANY')) {
                return $this->redirectToRoute('company_home');
            } elseif ($this->isGranted('ROLE_DEV')) {
                
                return $this->redirectToRoute('developer_home');
            }
        }

        // Si aucun utilisateur n'est connecté, afficher la page d'accueil générale
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

    #[Route('/company/home', name: 'company_home')]
    public function companyHome(DevelopperRepository $developerRepo): Response
    {
        // Récupérer les profils les plus consultés et les derniers profils créés
        $mostViewedProfiles = $developerRepo->findMostViewedProfiles(5);
        $latestProfiles = $developerRepo->findLatestProfiles(3);

        return $this->render('home/company_home.html.twig', [
            'mostViewedProfiles' => $mostViewedProfiles,
            'latestProfiles' => $latestProfiles,
        ]);
    }

    #[Route('/dev/home', name: 'developer_home')]
    public function developerHome(JobPostRepository $jobPostRepo): Response
    {
        
        // Récupérer les postes les plus populaires et les dernières offres publiées
        $mostViewedPosts = $jobPostRepo->findMostViewedPosts(5);
        $latestPosts = $jobPostRepo->findLatestPosts(3);

        return $this->render('home/dev_home.html.twig', [
            'mostViewedPosts' => $mostViewedPosts,
            'latestPosts' => $latestPosts,
        ]);
    }
}
