<?php

namespace App\Service;

use App\Dto\CampagneDto;
use App\Dto\MembreDto;
use App\Repository\CampagneRepository;

final class CampagneService
{
    public function __construct(private readonly CampagneRepository $campagneRepository)
    {
    }

    /** @return array{campagne: CampagneDto, membres: MembreDto[]}|null */
    public function detail(int $id): ?array
    {
        $campagne = $this->campagneRepository->findOneAvecMembres($id);
        if ($campagne === null) {
            return null;
        }

        return [
            'campagne' => CampagneDto::fromEntity($campagne),
            'membres' => array_map(
                MembreDto::fromAdhesion(...),
                $campagne->getAdhesions()->toArray()
            ),
        ];
    }
}
