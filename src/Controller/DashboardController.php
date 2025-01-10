<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(Request $request): Response
    {
        // Récupérer les notifications et l'historique des recherches depuis la session
        $notifications = $request->getSession()->get('notifications', []);
        $searchHistory = $request->getSession()->get('searchHistory', []);

        return $this->render('/recherche/dashboard.html.twig', [
            'notifications' => $notifications,
            'searchHistory' => $searchHistory,
        ]);
    }


    #[Route('/dashboard/add-notification', name: 'add_notification')]
    public function addNotification(Request $request): Response
    {
        $newNotification = "Une nouvelle correspondance a été trouvée.";
        $notifications = $request->getSession()->get('notifications', []);
        $notifications[] = $newNotification;
        $request->getSession()->set('notifications', $notifications);
        return $this->redirectToRoute('dashboard');
    }

    #[Route('/dashboard/add-search', name: 'add_search_history')]
    public function addSearchHistory(Request $request): Response
    {
        $searchQuery = 'Développeur PHP à Paris'; // Remplacez par la requête réelle
        $searchHistory = $request->getSession()->get('searchHistory', []);
        $searchHistory[] = ['query' => $searchQuery, 'date' => new \DateTime()];
        $request->getSession()->set('searchHistory', $searchHistory);

        return $this->redirectToRoute('dashboard');
    }
}
