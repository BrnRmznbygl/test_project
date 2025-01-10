<?php

namespace App\Controller;

use App\Repository\DevelopperRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\PostRepository;
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

    
}
