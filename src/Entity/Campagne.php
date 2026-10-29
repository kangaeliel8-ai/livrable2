<?php

namespace App\Entity;

use App\Enum\Periodicite;
use App\Enum\TypeCampagne;
use App\Repository\CampagneRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Campagne
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(enumType: TypeCampagne::class)]
    private ?TypeCampagne $type = null;

    #[ORM\Column(enumType: Periodicite::class)]
    private ?Periodicite $periodicite = null;

    #[ORM\Column(length: 20)]
    private ?string $jourRencontre = null;

    #[ORM\Column]
    private ?int $montantFixe = null;

    #[ORM\Column]
    private ?int $montantCaissePresent = null;

    #[ORM\Column]
    private ?int $montantCaisseAbsent = null;

    #[ORM\Column]
    private ?int $montantAmendeJournaliere = null;

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exercice $exercice = null;

    /** @var Collection<int, Adhesion> */
    #[ORM\OneToMany(targetEntity: Adhesion::class, mappedBy: 'campagne', orphanRemoval: true)]
    private Collection $adhesions;

    /** @var Collection<int, Seance> */
    #[ORM\OneToMany(targetEntity: Seance::class, mappedBy: 'campagne', orphanRemoval: true)]
    private Collection $seances;

    public function __construct()
    {
        $this->adhesions = new ArrayCollection();
        $this->seances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?TypeCampagne
    {
        return $this->type;
    }

    public function setType(?TypeCampagne $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPeriodicite(): ?Periodicite
    {
        return $this->periodicite;
    }

    public function setPeriodicite(?Periodicite $periodicite): static
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    public function getJourRencontre(): ?string
    {
        return $this->jourRencontre;
    }

    public function setJourRencontre(?string $jourRencontre): static
    {
        $this->jourRencontre = $jourRencontre;

        return $this;
    }

    public function getMontantFixe(): ?int
    {
        return $this->montantFixe;
    }

    public function setMontantFixe(?int $montantFixe): static
    {
        $this->montantFixe = $montantFixe;

        return $this;
    }

    public function getMontantCaissePresent(): ?int
    {
        return $this->montantCaissePresent;
    }

    public function setMontantCaissePresent(?int $montantCaissePresent): static
    {
        $this->montantCaissePresent = $montantCaissePresent;

        return $this;
    }

    public function getMontantCaisseAbsent(): ?int
    {
        return $this->montantCaisseAbsent;
    }

    public function setMontantCaisseAbsent(?int $montantCaisseAbsent): static
    {
        $this->montantCaisseAbsent = $montantCaisseAbsent;

        return $this;
    }

    public function getMontantAmendeJournaliere(): ?int
    {
        return $this->montantAmendeJournaliere;
    }

    public function setMontantAmendeJournaliere(?int $montantAmendeJournaliere): static
    {
        $this->montantAmendeJournaliere = $montantAmendeJournaliere;

        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): static
    {
        $this->exercice = $exercice;

        return $this;
    }

    /** @return Collection<int, Adhesion> */
    public function getAdhesions(): Collection
    {
        return $this->adhesions;
    }

    public function addAdhesion(Adhesion $adhesion): static
    {
        if (!$this->adhesions->contains($adhesion)) {
            $this->adhesions->add($adhesion);
            $adhesion->setCampagne($this);
        }

        return $this;
    }

    public function removeAdhesion(Adhesion $adhesion): static
    {
        if ($this->adhesions->removeElement($adhesion) && $adhesion->getCampagne() === $this) {
            $adhesion->setCampagne(null);
        }

        return $this;
    }

    /** @return Collection<int, Seance> */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): static
    {
        if (!$this->seances->contains($seance)) {
            $this->seances->add($seance);
            $seance->setCampagne($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): static
    {
        if ($this->seances->removeElement($seance) && $seance->getCampagne() === $this) {
            $seance->setCampagne(null);
        }

        return $this;
    }
}
