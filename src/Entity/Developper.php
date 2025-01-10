<?php

namespace App\Entity;

use App\Repository\DevelopperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: DevelopperRepository::class)]
class Developper
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'developper', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?User $UserDevelopper = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Localisation = null;

    #[ORM\Column]
    private int $views = 0;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $languages = null;

    #[ORM\Column(type: 'integer')]
    private $experienceLevel = 0;

    #[ORM\Column(nullable: true)]
    private ?float $minSalary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatarUrl = null;

    #[ORM\Column(type: 'float')]
    private $totalRatings = 0;

    #[ORM\Column(type: 'integer')]
    private $numberOfRatings = 0;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $evaluators;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->evaluators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    #[Ignore]
    public function getUserDevelopper(): ?User
    {
        return $this->UserDevelopper;
    }

    public function setUserDevelopper(User $UserDevelopper): static
    {
        $this->UserDevelopper = $UserDevelopper;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->Localisation;
    }

    public function setLocalisation(?string $Localisation): static
    {
        $this->Localisation = $Localisation;

        return $this;
    }

    public function getLanguages(): ?array
    {
        return $this->languages;
    }

    public function setLanguages(?array $languages): static
    {
        $this->languages = $languages;

        return $this;
    }

    public function getMinSalary(): ?float
    {
        return $this->minSalary;
    }

    public function setMinSalary(?float $minSalary): static
    {
        $this->minSalary = $minSalary;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): static
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getExperienceLevel(): ?int
    {
        return $this->experienceLevel;
    }

    public function setExperienceLevel(?int $experienceLevel): static
    {
        $this->experienceLevel = $experienceLevel;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function incrementViews(): static
    {
        $this->views += 1;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isProfilePublic(): bool
    {
        return $this->getUserDevelopper()->isPublic();
    }

    public function getTotalRatings(): float
    {
        return $this->totalRatings;
    }

    public function getNumberOfRatings(): int
    {
        return $this->numberOfRatings;
    }

    public function addRating(int $rating, User $evaluator): void
    {
        if (!$this->evaluators->contains($evaluator)) {
            $this->totalRatings += $rating;
            $this->numberOfRatings++;
            $this->evaluators[] = $evaluator;
        }
    }

    public function getAverageRating(): float
    {
        return $this->numberOfRatings > 0 ? $this->totalRatings / $this->numberOfRatings : 0;
    }

    /**
     * Récupère la note donnée par un utilisateur spécifique.
     */
    public function getRatingByUser(User $user): ?int
    {
        // Vérifie si l'utilisateur est dans la collection des évaluateurs
        if ($this->evaluators->contains($user)) {
            // Retourne la note associée à l'utilisateur
            return $this->totalRatings / $this->numberOfRatings; // Remplacer par la logique spécifique si nécessaire
        }

        // Retourne null si l'utilisateur n'a pas évalué
        return null;
    }

    /**
     * @return Collection<int, User>
     */
    public function getEvaluators(): Collection
    {
        return $this->evaluators;
    }

    public function __toString(): string
    {
        return $this->UserDevelopper ? $this->UserDevelopper->getEmail() : 'Developper';
    }
}
