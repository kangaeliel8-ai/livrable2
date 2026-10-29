<?php

namespace App\Entity;

use App\Repository\AmendeRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AmendeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Amende
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nombreJours = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column]
    private bool $isPayee = false;

    #[ORM\ManyToOne(inversedBy: 'amendes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adhesion $adhesion = null;

    #[ORM\ManyToOne(inversedBy: 'amendes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seance $seance = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreJours(): ?int
    {
        return $this->nombreJours;
    }

    public function setNombreJours(?int $nombreJours): static
    {
        $this->nombreJours = $nombreJours;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function isPayee(): bool
    {
        return $this->isPayee;
    }

    public function setIsPayee(bool $isPayee): static
    {
        $this->isPayee = $isPayee;

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
