<?php

namespace App\Dto;

use App\Entity\Campagne;

final readonly class CampagneDto
{
    public function __construct(
        public int $id,
        public string $nom,
        public string $type,
        public string $periodicite,
        public string $jourRencontre,
        public int $montantFixe,
        public string $exercice,
        public int $groupementId,
        public string $groupementNom,
    ) {
    }

    public static function fromEntity(Campagne $c): self
    {
        $e = $c->getExercice();
        $g = $e->getGroupement();

        return new self(
            $c->getId(),
            $c->getNom(),
            $c->getType()->label(),
            $c->getPeriodicite()->label(),
            $c->getJourRencontre(),
            $c->getMontantFixe(),
            $e->getDateDebut()->format('d/m/Y') . ' → ' . $e->getDateFin()->format('d/m/Y'),
            $g->getId(),
            $g->getNom(),
        );
    }
}
