<?php

namespace App\Dto;

use App\Entity\Groupement;
use App\Enum\StatutExercice;

final readonly class GroupementDto
{
    public function __construct(
        public int $id,
        public string $nom,
        public string $telephone,
        public string $adresse,
        public string $statut,
        public ?ExerciceDto $exerciceEnCours,
    ) {
    }

    public static function fromEntity(Groupement $g): self
    {
        // Résolution de l'« exercice en cours » : responsabilité du DTO, pas de la vue
        $enCours = null;
        foreach ($g->getExercices() as $exercice) {
            if ($exercice->getStatut() === StatutExercice::EN_COURS) {
                $enCours = ExerciceDto::fromEntity($exercice);
                break;
            }
        }

        return new self(
            $g->getId(),
            $g->getNom(),
            $g->getTelephone(),
            $g->getAdresse() ?? '—',
            $g->isActive() ? 'Actif' : 'Inactif',
            $enCours,
        );
    }
}
