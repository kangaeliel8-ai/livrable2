<?php

namespace App\Dto;

use App\Entity\Cotisation;

final readonly class CotisationLigneDto
{
    public function __construct(
        public string $membre,
        public string $presence,
        public int $montantEpargne,
        public int $montantCaisse,
    ) {
    }

    public static function fromEntity(Cotisation $c): self
    {
        $m = $c->getAdhesion()->getMembre();

        return new self(
            $m->getPrenom() . ' ' . $m->getNom(),
            $c->getPresence()->label(),
            $c->getMontantEpargne(),
            $c->getMontantCaisse(),
        );
    }
}
