<?php
namespace App\Service;

use App\Entity\Developper;
use App\Entity\Post;

class MatchingService
{
    /**
     * Effectue un matching entre les développeurs et un poste donné.
     *
     * @param array<Developper> $developers Liste de développeurs.
     * @param Post $post Le poste à matcher.
     * @param int $minScore Score minimal pour correspondre.
     * @return array Liste des développeurs correspondants.
     */
    public function matchDevelopersToPost(array $developers, Post $post, int $minScore): array
    {
        $matches = [];

        foreach ($developers as $developer) {
            $score = 0;

            // Vérifie les langages/technologies
            if (!empty($developer->getLanguages()) && !empty($post->getTechnologie())) {
                $developerLanguages = array_map('strtolower', $developer->getLanguages());
                $postTechnologies = array_map('strtolower', explode(',', $post->getTechnologie()));

                if (count(array_intersect($developerLanguages, $postTechnologies)) > 0) {
                    $score += 1;
                }
            }

            // Vérifie la localisation
            if ($developer->getLocalisation() === $post->getLocalisation()) {
                $score += 1;
            }

            // Vérifie le niveau d'expérience
            if ($developer->getExperienceLevel() >= $post->getExperienceLevel()) {
                $score += 1;
            }

            // Vérifie le salaire
            if ($developer->getMinSalary() !== null && $post->getSalary() !== null) {
                if ($developer->getMinSalary() <= $post->getSalary()) {
                    $score += 1;
                }
            }

            // Ajouter le développeur si le score est suffisant
            if ($score >= $minScore) {
                $matches[] = $developer;
            }
        }

        return $matches;
    }
}

