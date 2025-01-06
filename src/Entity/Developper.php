<?php

namespace App\Entity;

use App\Repository\DevelopperRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevelopperRepository::class)]
class Developper
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'developper', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $UserDevelopper = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Localisation = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $languages = null;

    #[ORM\Column(nullable: true)]
    private ?float $minSalary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatarUrl = null;

    /**
     * @var Collection<int, Entreprise>
     */
    #[ORM\ManyToMany(targetEntity: Entreprise::class)]
    private Collection $favoriteEntreprises;

    /**
     * @var Collection<int, Post>
     */
    #[ORM\ManyToMany(targetEntity: Post::class)]
    private Collection $favoritePosts;

    /**
     * @var Collection<int, self>
     */
    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $favoriteDeveloppers;

    public function __construct()
    {
        $this->favoriteEntreprises = new ArrayCollection();
        $this->favoritePosts = new ArrayCollection();
        $this->favoriteDeveloppers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    /**
     * @return Collection<int, Entreprise>
     */
    public function getFavoriteEntreprises(): Collection
    {
        return $this->favoriteEntreprises;
    }

    public function addFavoriteEntreprise(Entreprise $favoriteEntreprise): static
    {
        if (!$this->favoriteEntreprises->contains($favoriteEntreprise)) {
            $this->favoriteEntreprises->add($favoriteEntreprise);
        }

        return $this;
    }

    public function removeFavoriteEntreprise(Entreprise $favoriteEntreprise): static
    {
        $this->favoriteEntreprises->removeElement($favoriteEntreprise);

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getFavoritePosts(): Collection
    {
        return $this->favoritePosts;
    }

    public function addFavoritePost(Post $favoritePost): static
    {
        if (!$this->favoritePosts->contains($favoritePost)) {
            $this->favoritePosts->add($favoritePost);
        }

        return $this;
    }

    public function removeFavoritePost(Post $favoritePost): static
    {
        $this->favoritePosts->removeElement($favoritePost);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getFavoriteDeveloppers(): Collection
    {
        return $this->favoriteDeveloppers;
    }

    public function addFavoriteDevelopper(self $favoriteDevelopper): static
    {
        if (!$this->favoriteDeveloppers->contains($favoriteDevelopper)) {
            $this->favoriteDeveloppers->add($favoriteDevelopper);
        }

        return $this;
    }

    public function removeFavoriteDevelopper(self $favoriteDevelopper): static
    {
        $this->favoriteDeveloppers->removeElement($favoriteDevelopper);

        return $this;
    }
}
