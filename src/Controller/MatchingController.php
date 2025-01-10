<?php
namespace App\Controller;

use App\Entity\Post;
use App\Form\MatchingFormType;
use App\Repository\DevelopperRepository;
use App\Service\DeveloperSuggestionService;
use App\Service\PostSuggestionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchingController extends AbstractController
{
    #[Route('/company/post/{id}/suggestions', name: 'company_suggestions')]
public function suggestDevelopers(
    Post $post,
    DeveloperSuggestionService $developerSuggestionService,
): Response {
    $suggestedDevelopers = $developerSuggestionService->suggestDevelopersForPost($post);
    return $this->render('recherche/matching.html.twig', [
        'suggestedDevelopers' => $suggestedDevelopers,
    ]);
}

    #[Route('/dev/suggestions', name: 'developer_suggestions')]
    public function suggestPosts(
        PostSuggestionService $suggestionService,
        DevelopperRepository $developerRepository
    ): Response {
    $developer = $developerRepository->findOneBy(['UserDevelopper' => $this->getUser()]);
    $suggestedPosts = $suggestionService->suggestPostsForDeveloper($developer);

        return $this->render('recherche/postSuggestion.html.twig', [
        'suggestedPosts' => $suggestedPosts,
    ]);
}
}
