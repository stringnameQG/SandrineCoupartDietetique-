<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'L\'email ne peut pas être vide')]
    #[Assert\Length(
        min: 5,
        max: 180,
        minMessage: 'L\'email doit faire au moin 5 caractères',
        maxMessage: 'Impossible de dépasser les 180 caractéres'
    )]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Allergens::class, inversedBy: 'users')]
    public Collection $Allergens;

    #[ORM\ManyToMany(targetEntity: Diet::class, inversedBy: 'users')]
    public Collection $Diet;

    #[ORM\OneToMany(targetEntity: View::class, mappedBy: 'userId')]
    private Collection $views;

    public function __construct()
    {
        $this->Allergens = new ArrayCollection();
        $this->Diet = new ArrayCollection();
        $this->views = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Allergens>
     */
    public function getAllergens(): Collection
    {
        return $this->Allergens;
    }

    public function addAllergen(Allergens $allergen): static
    {
        if (!$this->Allergens->contains($allergen)) {
            $this->Allergens->add($allergen);
        }

        return $this;
    }

    public function removeAllergen(Allergens $allergen): static
    {
        $this->Allergens->removeElement($allergen);

        return $this;
    }

    /**
     * @return Collection<int, Diet>
     */
    public function getDiet(): Collection
    {
        return $this->Diet;
    }

    public function addDiet(Diet $diet): static
    {
        if (!$this->Diet->contains($diet)) {
            $this->Diet->add($diet);
        }

        return $this;
    }

    public function removeDiet(Diet $diet): static
    {
        $this->Diet->removeElement($diet);

        return $this;
    }

    /**
     * @return Collection<int, View>
     */
    public function getViews(): Collection
    {
        return $this->views;
    }

    public function addView(View $view): static
    {
        if (!$this->views->contains($view)) {
            $this->views->add($view);
            $view->setUserId($this);
        }

        return $this;
    }

    public function removeView(View $view): static
    {
        if ($this->views->removeElement($view)) {
            // set the owning side to null (unless already changed)
            if ($view->getUserId() === $this) {
                $view->setUserId(null);
            }
        }

        return $this;
    }
}
