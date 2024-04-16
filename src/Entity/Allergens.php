<?php

namespace App\Entity;

use App\Repository\AllergensRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AllergensRepository::class)]
class Allergens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La description ne peut pas être vide')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'La description doit faire au moin 5 caractères',
        maxMessage: 'Impossible de dépasser les 255 caractéres'
    )]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La nom ne peut pas être vide')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'La nom doit faire au moin 3 caractères',
        maxMessage: 'Impossible de dépasser les 255 caractéres'
    )]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Allergens')]
    private Collection $users;

    #[ORM\ManyToMany(targetEntity: Recipe::class, mappedBy: 'allergens')]
    private Collection $recipes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->recipes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addAllergen($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeAllergen($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->addAllergen($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            $recipe->removeAllergen($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
