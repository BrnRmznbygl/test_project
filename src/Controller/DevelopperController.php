<?php

namespace App\Controller;

use App\Entity\Developper;
use App\Form\DevelopperType;
use App\Form\SearchDevType;
use App\Repository\DevelopperRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class DevelopperController extends AbstractController
{
    #[Route('/profile/developper/{id}', name: 'developper_profile')]
    public function show(int $id, DevelopperRepository $repository, EntityManagerInterface $entityManager): Response
    {
        $developper = $repository->find($id);
        if (!$developper) {
            throw $this->createNotFoundException('Developper not found');
        }

        if ($developper->getUserDevelopper() !== $this->getUser()) {
            $developper->incrementViews();
            $entityManager->flush();
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
            /** @var UploadedFile $avatarFile */
            $avatarFile = $form->get('avatarUrl')->getData();

            if ($avatarFile) {
                $newFilename = uniqid().'.'.$avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('erreur', 'Veuillez réessayer.');
                }

                $developper->setAvatarUrl('uploads/avatars/' . $newFilename);
            } else {
                if (!$developper->getAvatarUrl()) {
                    $developper->setAvatarUrl('uploads/avatars/default.jpg');
                }
            }

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
    public function index(DevelopperRepository $repository, PostRepository $postRepository): Response
    {
        $user = $this->getUser();
        $developper = $repository->findOneBy(['UserDevelopper' => $user]);

        $mostViewedPosts = $postRepository->findMostViewedPosts(5);
        $latestPosts = $postRepository->findLatestPosts(3);

        return $this->render('/home/dev_home.html.twig', [
            'developper' => $developper,
            'mostViewedPosts' => $mostViewedPosts,
            'latestPosts' => $latestPosts,
            'profileViews' => $developper->getViews(),
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

    #[Route('/searchdevelopper', name: 'search_developper')]
    public function search(Request $request, DevelopperRepository $repository): Response
    {
        $form = $this->createForm(SearchDevType::class);
        $form->handleRequest($request);

        $developers = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $criteria = [
                'firstName' => $data->getFirstName(),
                'lastName' => $data->getLastName(),
                'Localisation' => $data->getLocalisation(),
                'experienceLevel' => $data->getExperienceLevel(),
                'languages' => $data->getLanguages(),
                'minSalary' => $data->getMinSalary(),
            ];
            $developers = $repository->findBySearchCriteria($criteria);
        }

        return $this->render('recherche/searchdev.html.twig', [
            'form' => $form->createView(),
            'developers' => $developers,
        ]);
    }

    #[Route('/evaluate/{id}', name: 'evaluate_developer', methods: ['POST'])]
    public function evaluate(Request $request, Developper $developper, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour évaluer un développeur.');
            return $this->redirectToRoute('developper_profile', ['id' => $developper->getId()]);
        }

        if ($user === $developper->getUserDevelopper()) {
            $this->addFlash('error', 'Vous ne pouvez pas vous évaluer vous-même.');
            return $this->redirectToRoute('developper_profile', ['id' => $developper->getId()]);
        }

        $rating = $request->request->getInt('rating');

        if ($rating < 1 || $rating > 5) {
            $this->addFlash('error', 'Veuillez choisir une note valide entre 1 et 5.');
        } else {
            $existingRating = $developper->getRatingByUser($user);

            if ($existingRating) {
                $existingRating['rating'] = $rating;
                $this->addFlash('success', 'Votre évaluation a été mise à jour.');
            } else {
                $developper->addRating($rating, $user);
                $this->addFlash('success', 'Votre évaluation a été ajoutée.');
            }

            $em->persist($developper);
            $em->flush();
        }

        return $this->redirectToRoute('developper_profile', ['id' => $developper->getId()]);
    }
}
