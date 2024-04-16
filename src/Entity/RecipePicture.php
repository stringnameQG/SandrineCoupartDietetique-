<?php

namespace App\Entity;

use App\Repository\RecipePictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipePictureRepository::class)]
class RecipePicture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La nom ne peut pas être vide')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'La nom doit faire au moin 3 caractères',
        maxMessage: 'Impossible de dépasser les 255 caractéres'
    )]
    public ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'picture')]
    #[ORM\JoinColumn(nullable: false)]
    private ?recipe $recipe = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRecipe(): ?recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }
}
