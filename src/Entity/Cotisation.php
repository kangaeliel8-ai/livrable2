<?php

namespace App\Entity;

use App\Enum\StatutPresence;
use App\Repository\CotisationRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CotisationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Cotisation
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $montantEpargne = null;

    #[ORM\Column]
    private ?int $montantCaisse = null;

    #[ORM\Column(enumType: StatutPresence::class)]
    private ?StatutPresence $presence = null;

    #[ORM\ManyToOne(inversedBy: 'cotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adhesion $adhesion = null;

    #[ORM\ManyToOne(inversedBy: 'cotisations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seance $seance = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantEpargne(): ?int
    {
        return $this->montantEpargne;
    }

    public function setMontantEpargne(?int $montantEpargne): static
    {
        $this->montantEpargne = $montantEpargne;

        return $this;
    }

    public function getMontantCaisse(): ?int
    {
        return $this->montantCaisse;
    }

    public function setMontantCaisse(?int $montantCaisse): static
    {
        $this->montantCaisse = $montantCaisse;

        return $this;
    }

    public function getPresence(): ?StatutPresence
    {
        return $this->presence;
    }

    public function setPresence(?StatutPresence $presence): static
    {
        $this->presence = $presence;

        return $this;
    }

    public function getAdhesion(): ?Adhesion
    {
        return $this->adhesion;
    }

    public function setAdhesion(?Adhesion $adhesion): static
    {
        $this->adhesion = $adhesion;

        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): static
    {
        $this->seance = $seance;

        return $this;
    }
}
