<?php

namespace App\Entity;

use App\Repository\AdhesionRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdhesionRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'uniq_membre_campagne', columns: ['membre_id', 'campagne_id'])]
class Adhesion
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private bool $isMontantLibre = false;

    #[ORM\Column(nullable: true)]
    private ?int $montantEngage = null;

    #[ORM\ManyToOne(inversedBy: 'adhesions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $membre = null;

    #[ORM\ManyToOne(inversedBy: 'adhesions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campagne $campagne = null;

    /** @var Collection<int, Cotisation> */
    #[ORM\OneToMany(targetEntity: Cotisation::class, mappedBy: 'adhesion', orphanRemoval: true)]
    private Collection $cotisations;

    /** @var Collection<int, Amende> */
    #[ORM\OneToMany(targetEntity: Amende::class, mappedBy: 'adhesion', orphanRemoval: true)]
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

    public function isMontantLibre(): bool
    {
        return $this->isMontantLibre;
    }

    public function setIsMontantLibre(bool $isMontantLibre): static
    {
        $this->isMontantLibre = $isMontantLibre;

        return $this;
    }

    public function getMontantEngage(): ?int
    {
        return $this->montantEngage;
    }

    public function setMontantEngage(?int $montantEngage): static
    {
        $this->montantEngage = $montantEngage;

        return $this;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): static
    {
        $this->membre = $membre;

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
            $cotisation->setAdhesion($this);
        }

        return $this;
    }

    public function removeCotisation(Cotisation $cotisation): static
    {
        if ($this->cotisations->removeElement($cotisation) && $cotisation->getAdhesion() === $this) {
            $cotisation->setAdhesion(null);
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
            $amende->setAdhesion($this);
        }

        return $this;
    }

    public function removeAmende(Amende $amende): static
    {
        if ($this->amendes->removeElement($amende) && $amende->getAdhesion() === $this) {
            $amende->setAdhesion(null);
        }

        return $this;
    }
}
