<?php

namespace App\Entity;

use App\Repository\ViewRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ViewRepository::class)]
class View
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'L\'avis doit contenir une note')]
    #[Assert\PositiveOrZero(message: 'La note doit étre un entier positif')]
    #[Assert\Range(
        min: 0,
        max: 5,
        notInRangeMessage: 'La note doit étre entre 0 et 5',
    )]
    private ?int $score = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'L\'avis doit contenir un commentaire')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Impossible de dépasser les 255 caractéres'
    )]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'view')]
    private ?Recipe $recipe = null;

    #[ORM\ManyToOne(inversedBy: 'views')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }
}
