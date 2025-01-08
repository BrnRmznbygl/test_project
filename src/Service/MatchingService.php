<?php
namespace App\Service;

use App\Repository\DevelopperRepository;
use App\Repository\PostRepository;

class MatchingService
{
    private $developperRepository;
    private $postRepository;

    public function __construct(DevelopperRepository $developperRepo, PostRepository $postRepo)
    {
        $this->developperRepository = $developperRepo;
        $this->postRepository = $postRepo;
    }

    public function findMatchesForDevelopper($developper)
    {
        $criteria = [
            'languages' => $developper->getLanguages(),
            'Localisation' => $developper->getLocalisation(),
            'minSalary' => $developper->getMinSalary(),
            'experienceLevel' => $developper->getExperienceLevel(),
        ];

        return $this->postRepository->findMatchingPosts($criteria);
    }

    public function findMatchesForPost($post)
    {
        $criteria = [
            'Technologie' => $post->getTechnologie(),
            'localisation' => $post->getLocalisation(),
            'salary' => $post->getSalary(),
            'experienceLevel' => $post->getExperienceLevel(),
        ];

        return $this->developperRepository->findMatchingDeveloppers($criteria);
    }
}
