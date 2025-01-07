<?php

namespace App\Controller;

use App\Repository\DevelopperRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
