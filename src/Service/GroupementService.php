<?php

namespace App\Service;

use App\Dto\CampagneDto;
use App\Dto\GroupementDto;
use App\Repository\CampagneRepository;
use App\Repository\GroupementRepository;

final class GroupementService
{
    public function __construct(
        private readonly GroupementRepository $groupementRepository,
        private readonly CampagneRepository $campagneRepository,
    ) {
    }

    /** @return GroupementDto[] */
    public function lister(): array
    {
        return array_map(
            GroupementDto::fromEntity(...),
            $this->groupementRepository->findAllAvecExerciceEnCours()
        );
    }

    /** @return array{groupement: GroupementDto, campagnes: CampagneDto[]}|null */
    public function detail(int $id): ?array
    {
        $groupement = $this->groupementRepository->find($id);
        if ($groupement === null) {
            return null; // le contrôleur décidera du 404 : le service ignore HTTP
        }

        return [
            'groupement' => GroupementDto::fromEntity($groupement),
            'campagnes' => array_map(
                CampagneDto::fromEntity(...),
                $this->campagneRepository->findByGroupement($id)
            ),
        ];
    }
}
