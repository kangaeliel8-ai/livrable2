<?php

namespace App\Dto;

use App\Entity\Adhesion;

final readonly class MembreDto
{
    public function __construct(
        public int $id,
        public string $nomComplet,
        public string $telephone,
        public string $mode,
        public ?int $montantEngage,
    ) {
    }

    public static function fromAdhesion(Adhesion $a): self
    {
        $m = $a->getMembre();

        return new self(
            $m->getId(),
            $m->getPrenom() . ' ' . $m->getNom(),
            $m->getTelephone(),
            $a->isMontantLibre() ? 'Montant libre' : 'Montant fixe',
            $a->getMontantEngage(),
        );
    }
}
