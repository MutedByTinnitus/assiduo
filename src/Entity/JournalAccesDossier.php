<?php

namespace App\Entity;

use App\Repository\JournalAccesDossierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JournalAccesDossierRepository::class)]
class JournalAccesDossier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $dateConsultation = null;

    #[ORM\Column]
    private ?bool $autorise = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleve $eleve = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateConsultation(): ?\DateTimeImmutable
    {
        return $this->dateConsultation;
    }

    public function setDateConsultation(\DateTimeImmutable $dateConsultation): static
    {
        $this->dateConsultation = $dateConsultation;

        return $this;
    }

    public function isAutorise(): ?bool
    {
        return $this->autorise;
    }

    public function setAutorise(bool $autorise): static
    {
        $this->autorise = $autorise;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }
}
