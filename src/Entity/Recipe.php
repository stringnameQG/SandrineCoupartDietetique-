<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; 

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La titre ne peut pas être vide')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'La titre doit faire au moin 3 caractères',
        maxMessage: 'Impossible de dépasser les 255 caractéres'
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La description ne peut pas être vide')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'La description doit faire au moin 5 caractères',
        maxMessage: 'Impossible de dépasser les 255 caractéres'
    )]
    private ?string $description = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $breakTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $cookingTime = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Il faut renseigner les ingrédiants')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'La liste d\'grédiant doit faire au moin 5 caractères',
        maxMessage: 'Impossible de dépasser les 255 caractéres'
    )]
    private ?string $ingredients = null;

    #[ORM\Column]
    private ?bool $public = null;

    #[ORM\ManyToMany(targetEntity: Allergens::class, inversedBy: 'recipes')]
    private Collection $allergens;

    #[ORM\ManyToMany(targetEntity: Diet::class, inversedBy: 'recipes')]
    private Collection $diet;

    #[ORM\OneToMany(targetEntity: View::class, mappedBy: 'recipe', cascade: ['persist', 'remove'])]
    private Collection $view;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipePicture::class, orphanRemoval: true, cascade: ['persist'])]
    public Collection $picture;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $step = null;

    public function __construct()
    {
        $this->allergens = new ArrayCollection();
        $this->diet = new ArrayCollection();
        $this->view = new ArrayCollection();
        $this->picture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
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

    public function getBreakTime(): ?\DateTimeInterface
    {
        return $this->breakTime;
    }

    public function setBreakTime(?\DateTimeInterface $breakTime): static
    {
        $this->breakTime = $breakTime;

        return $this;
    }

    public function getCookingTime(): ?\DateTimeInterface
    {
        return $this->cookingTime;
    }

    public function setCookingTime(?\DateTimeInterface $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): static
    {
        $this->public = $public;

        return $this;
    }

    /**
     * @return Collection<int, Allergens>
     */

    public function getAllergens(): Collection
    {
        return $this->allergens;
    }

    public function addAllergen(Allergens $allergen): static
    {
        if (!$this->allergens->contains($allergen)) {
            $this->allergens->add($allergen);
        }

        return $this;
    }

    public function removeAllergen(Allergens $allergen): static
    {
        $this->allergens->removeElement($allergen);

        return $this;
    }

    /**
     * @return Collection<int, Diet>
     */
    public function getDiet(): Collection
    {
        return $this->diet;
    }

    public function addDiet(Diet $diet): static
    {
        if (!$this->diet->contains($diet)) {
            $this->diet->add($diet);
        }

        return $this;
    }

    public function removeDiet(Diet $diet): static
    {
        $this->diet->removeElement($diet);

        return $this;
    }

    /**
     * @return Collection<int, View>
     */
    public function getView(): Collection
    {
        return $this->view;
    }

    public function addView(View $view): static
    {
        if (!$this->view->contains($view)) {
            $this->view->add($view);
            $view->setRecipe($this);
        }

        return $this;
    }

    public function removeView(View $view): static
    {
        if ($this->view->removeElement($view)) {
            // set the owning side to null (unless already changed)
            if ($view->getRecipe() === $this) {
                $view->setRecipe(null);
            }
        }

        return $this;
    }
    
    /**
     * @return Collection<int, RecipePicture>
     */
    public function getPicture(): Collection
    {
        return $this->picture;
    }

    public function addPicture(RecipePicture $picture): static
    {
        if (!$this->picture->contains($picture)) {
            $this->picture->add($picture);
            $picture->setRecipe($this);
        }

        return $this;
    }

    public function removePicture(RecipePicture $picture): static
    {
        if ($this->picture->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getRecipe() === $this) {
                $picture->getRecipe(null);
            }
        }

        return $this;
    }

    public function getStep(): ?string
    {
        return $this->step;
    }

    public function setStep(string $step): static
    {
        $this->step = $step;

        return $this;
    }
}
