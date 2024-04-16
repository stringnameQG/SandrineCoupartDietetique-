<?php

namespace App\Entity;

use App\Repository\ContacteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContacteRepository::class)]
class Contacte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La demande doit contenir un email')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Impossible de dépasser les 255 caractéres'
    )]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La demande doit contenir un texte')]
    #[Assert\Length(
        max: 500,
        maxMessage: 'Impossible de dépasser les 500 caractéres'
    )]
    private ?string $demande = null;

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

    public function getDemande(): ?string
    {
        return $this->demande;
    }

    public function setDemande(string $demande): static
    {
        $this->demande = $demande;

        return $this;
    }
}
