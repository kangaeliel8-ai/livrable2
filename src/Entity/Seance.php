<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Seance
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateSeance = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campagne $campagne = null;

    /** @var Collection<int, Cotisation> */
    #[ORM\OneToMany(targetEntity: Cotisation::class, mappedBy: 'seance', orphanRemoval: true)]
    private Collection $cotisations;

    /** @var Collection<int, Amende> */
    #[ORM\OneToMany(targetEntity: Amende::class, mappedBy: 'seance', orphanRemoval: true)]
    private Collection $amendes;

    public function __construct()
    {
        $this->cotisations = new ArrayCollection();
        $this->amendes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDateSeance(): ?\DateTimeImmutable
    {
        return $this->dateSeance;
    }

    public function setDateSeance(?\DateTimeImmutable $dateSeance): static
    {
        $this->dateSeance = $dateSeance;

        return $this;
    }

    public function getCampagne(): ?Campagne
    {
        return $this->campagne;
    }

    public function setCampagne(?Campagne $campagne): static
    {
        $this->campagne = $campagne;

        return $this;
    }

    /** @return Collection<int, Cotisation> */
    public function getCotisations(): Collection
    {
        return $this->cotisations;
    }

    public function addCotisation(Cotisation $cotisation): static
    {
        if (!$this->cotisations->contains($cotisation)) {
            $this->cotisations->add($cotisation);
            $cotisation->setSeance($this);
        }

        return $this;
    }

    public function removeCotisation(Cotisation $cotisation): static
    {
        if ($this->cotisations->removeElement($cotisation) && $cotisation->getSeance() === $this) {
            $cotisation->setSeance(null);
        }

        return $this;
    }

    /** @return Collection<int, Amende> */
    public function getAmendes(): Collection
    {
        return $this->amendes;
    }

    public function addAmende(Amende $amende): static
    {
        if (!$this->amendes->contains($amende)) {
            $this->amendes->add($amende);
            $amende->setSeance($this);
        }

        return $this;
    }

    public function removeAmende(Amende $amende): static
    {
        if ($this->amendes->removeElement($amende) && $amende->getSeance() === $this) {
            $amende->setSeance(null);
        }

        return $this;
    }
}
