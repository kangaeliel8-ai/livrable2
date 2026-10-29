<?php

namespace App\Entity;

use App\Enum\StatutExercice;
use App\Repository\ExerciceRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Exercice
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateDebut = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateFin = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateLimitePret = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateRetribution = null;

    #[ORM\Column(enumType: StatutExercice::class)]
    private StatutExercice $statut = StatutExercice::EN_COURS;

    #[ORM\ManyToOne(inversedBy: 'exercices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

    /** @var Collection<int, Campagne> */
    #[ORM\OneToMany(targetEntity: Campagne::class, mappedBy: 'exercice', orphanRemoval: true)]
    private Collection $campagnes;

    public function __construct()
    {
        $this->campagnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeImmutable $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeImmutable $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateLimitePret(): ?\DateTimeImmutable
    {
        return $this->dateLimitePret;
    }

    public function setDateLimitePret(?\DateTimeImmutable $dateLimitePret): static
    {
        $this->dateLimitePret = $dateLimitePret;

        return $this;
    }

    public function getDateRetribution(): ?\DateTimeImmutable
    {
        return $this->dateRetribution;
    }

    public function setDateRetribution(?\DateTimeImmutable $dateRetribution): static
    {
        $this->dateRetribution = $dateRetribution;

        return $this;
    }

    public function getStatut(): StatutExercice
    {
        return $this->statut;
    }

    public function setStatut(StatutExercice $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getGroupement(): ?Groupement
    {
        return $this->groupement;
    }

    public function setGroupement(?Groupement $groupement): static
    {
        $this->groupement = $groupement;

        return $this;
    }

    /** @return Collection<int, Campagne> */
    public function getCampagnes(): Collection
    {
        return $this->campagnes;
    }

    public function addCampagne(Campagne $campagne): static
    {
        if (!$this->campagnes->contains($campagne)) {
            $this->campagnes->add($campagne);
            $campagne->setExercice($this);
        }

        return $this;
    }

    public function removeCampagne(Campagne $campagne): static
    {
        if ($this->campagnes->removeElement($campagne) && $campagne->getExercice() === $this) {
            $campagne->setExercice(null);
        }

        return $this;
    }
}
