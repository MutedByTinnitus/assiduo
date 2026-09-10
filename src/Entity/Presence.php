<?php

namespace App\Entity;

use App\Repository\PresenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
#[ORM\UniqueConstraint(name: 'uniq_appel_eleve', fields: ['appel', 'eleve'])]
class Presence
{
    public const STATUT_PRESENT = 'present';
    public const STATUT_ABSENT = 'absent';
    public const STATUT_RETARD = 'retard';

    public const QUALIFICATION_NON_TRAITE = 'non_traite';
    public const QUALIFICATION_JUSTIFIEE = 'justifiee';
    public const QUALIFICATION_INJUSTIFIEE = 'injustifiee';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = null;

    #[ORM\Column(nullable: true)]
    private ?int $dureeRetardMinutes = null;

    #[ORM\Column(length: 20)]
    private string $qualification = self::QUALIFICATION_NON_TRAITE;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $motif = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $justificatifTexte = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateTraitement = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Appel $appel = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleve $eleve = null;

    #[ORM\ManyToOne]
    private ?User $traitePar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDureeRetardMinutes(): ?int
    {
        return $this->dureeRetardMinutes;
    }

    public function setDureeRetardMinutes(?int $dureeRetardMinutes): static
    {
        $this->dureeRetardMinutes = $dureeRetardMinutes;

        return $this;
    }

    public function getQualification(): string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): static
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getJustificatifTexte(): ?string
    {
        return $this->justificatifTexte;
    }

    public function setJustificatifTexte(?string $justificatifTexte): static
    {
        $this->justificatifTexte = $justificatifTexte;

        return $this;
    }

    public function getDateTraitement(): ?\DateTimeImmutable
    {
        return $this->dateTraitement;
    }

    public function setDateTraitement(?\DateTimeImmutable $dateTraitement): static
    {
        $this->dateTraitement = $dateTraitement;

        return $this;
    }

    public function getAppel(): ?Appel
    {
        return $this->appel;
    }

    public function setAppel(?Appel $appel): static
    {
        $this->appel = $appel;

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

    public function getTraitePar(): ?User
    {
        return $this->traitePar;
    }

    public function setTraitePar(?User $traitePar): static
    {
        $this->traitePar = $traitePar;

        return $this;
    }
}
