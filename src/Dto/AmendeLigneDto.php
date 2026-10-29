<?php

namespace App\Dto;

use App\Entity\Amende;

final readonly class AmendeLigneDto
{
    public function __construct(
        public string $membre,
        public int $nombreJours,
        public int $montant,
        public string $statut,
    ) {
    }

    public static function fromEntity(Amende $a): self
    {
        $m = $a->getAdhesion()->getMembre();

        return new self(
            $m->getPrenom() . ' ' . $m->getNom(),
            $a->getNombreJours(),
            $a->getMontant(),
            $a->isPayee() ? 'Payée' : 'Non payée',
        );
    }
}
