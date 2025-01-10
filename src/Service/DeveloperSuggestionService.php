<?php
namespace App\Service;

use App\Entity\Developper;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class DeveloperSuggestionService
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * Renvoie les 3 meilleurs développeurs suggérés pour un poste avec les scores.
     *
     * @param Post $post La fiche de poste.
     * @return array Liste des développeurs suggérés avec leur score.
     */
    public function suggestDevelopersForPost(Post $post): array
    {
        $developers = $this->em->getRepository(Developper::class)->findAll();
        $suggestions = [];
        $maxScore = 4; // Nombre total de critères

        foreach ($developers as $developer) {
            $score = 0;

            // Correspondance des technologies/langages
            if (!empty($developer->getLanguages()) && !empty($post->getTechnologie())) {
                $developerLanguages = array_map('strtolower', $developer->getLanguages());
                $postTechnologies = array_map('strtolower', $post->getTechnologie());
                if (count(array_intersect($developerLanguages, $postTechnologies)) > 0) {
                    $score += 1;
                }
            }

            // Correspondance de la localisation
            if ($developer->getLocalisation() === $post->getLocalisation()) {
                $score += 1;
            }

            // Correspondance du niveau d'expérience
            if ($developer->getExperienceLevel() >= $post->getExperienceLevel()) {
                $score += 1;
            }

            // Correspondance du salaire
            if ($post->getSalary() !== null && $developer->getMinSalary() !== null) {
                if ($post->getSalary() >= $developer->getMinSalary()) {
                    $score += 1;
                }
            }

            // Calcul du score en pourcentage
            $matchPercentage = ($score / $maxScore) * 100;

            $suggestions[] = [
                'developer' => $developer,
                'score' => $matchPercentage,
            ];
        }

        // Trier les suggestions par score décroissant
        usort($suggestions, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Retourner les 3 meilleures suggestions
        return array_slice($suggestions, 0, 3);
    }
}

