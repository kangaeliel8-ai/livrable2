<?php

namespace App\Service;

use App\Dto\SeanceDetailDto;
use App\Dto\SeanceTotauxDto;
use App\Repository\AmendeRepository;
use App\Repository\SeanceRepository;

final class SeanceService
{
    public function __construct(
        private readonly SeanceRepository $seanceRepository,
        private readonly AmendeRepository $amendeRepository,
    ) {
    }

    /** @return SeanceTotauxDto[] */
    public function totauxParCampagne(int $campagneId): array
    {
        return array_map(
            SeanceTotauxDto::fromRow(...),
            $this->seanceRepository->findTotauxParCampagne($campagneId)
        );
    }

    public function detail(int $id): ?SeanceDetailDto
    {
        $seance = $this->seanceRepository->findOneDetail($id);
        if ($seance === null) {
            return null;
        }

        return SeanceDetailDto::fromEntities(
            $seance,
            $this->amendeRepository->findBySeance($id)
        );
    }
}
