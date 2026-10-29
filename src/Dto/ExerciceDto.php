<?php

namespace App\Dto;

use App\Entity\Exercice;

final readonly class ExerciceDto
{
    public function __construct(
        public int $id,
        public string $dateDebut,
        public string $dateFin,
        public string $dateLimitePret,
        public string $dateRetribution,
        public string $statut,
    ) {
    }

    public static function fromEntity(Exercice $e): self
    {
        return new self(
            $e->getId(),
            $e->getDateDebut()->format('d/m/Y'),
            $e->getDateFin()->format('d/m/Y'),
            $e->getDateLimitePret()->format('d/m/Y'),
            $e->getDateRetribution()->format('d/m/Y'),
            $e->getStatut()->label(),
        );
    }
}
