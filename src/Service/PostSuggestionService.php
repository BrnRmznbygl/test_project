<?php
namespace App\Service;

use App\Entity\Developper;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostSuggestionService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

     /**
     * Renvoie les 3 meilleurs postes suggérés pour un développeur avec les scores.
     *
     * @param Developper $developer Le développeur connecté.
     * @return array Liste des fiches de postes suggérées avec leur score.
     */
    public function suggestPostsForDeveloper(Developper $developer): array
    {
        $posts = $this->em->getRepository(Post::class)->findAll();
        $suggestions = [];

        foreach ($posts as $post) {
            $score = 0;
            $maxScore = 4; // Nombre total de critères

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
            if ($post->getExperienceLevel() <= $developer->getExperienceLevel()) {
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
                'post' => $post,
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
