<?php

namespace App\Entity;

use App\Repository\AppelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppelRepository::class)]
#[ORM\UniqueConstraint(name: 'uniq_creneau_date', fields: ['creneau', 'date'])]
class Appel
{
    public const STATUT_OUVERT = 'ouvert';
    public const STATUT_VERROUILLE = 'verrouille';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(length: 20)]
    private string $statut = self::STATUT_OUVERT;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $horodatageValidation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Creneau $creneau = null;

    #[ORM\ManyToOne]
    private ?User $realisePar = null;

    /**
     * @var Collection<int, Presence>
     */
    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'appel')]
    private Collection $presences;

    public function __construct()
    {
        $this->presences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getHorodatageValidation(): ?\DateTimeImmutable
    {
        return $this->horodatageValidation;
    }

    public function setHorodatageValidation(?\DateTimeImmutable $horodatageValidation): static
    {
        $this->horodatageValidation = $horodatageValidation;

        return $this;
    }

    public function getCreneau(): ?Creneau
    {
        return $this->creneau;
    }

    public function setCreneau(?Creneau $creneau): static
    {
        $this->creneau = $creneau;

        return $this;
    }

    public function getRealisePar(): ?User
    {
        return $this->realisePar;
    }

    public function setRealisePar(?User $realisePar): static
    {
        $this->realisePar = $realisePar;

        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }
}
