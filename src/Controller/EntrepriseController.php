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
        $entreprise = $repository->find($id);

        if (!$entreprise) {
            throw $this->createNotFoundException('Entreprise not found');
        }

        return $this->render('profile/entreprise.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }
}
