<?php

namespace App\Dto;

final readonly class SeanceTotauxDto
{
    public function __construct(
        public int $id,
        public int $numero,
        public string $date,
        public int $totalCollecte,
        public int $totalAmendes,
        public int $totalCaisse,
    ) {
    }

    /** @param array<string, mixed> $row ligne issue de SeanceRepository::findTotauxParCampagne() */
    public static function fromRow(array $row): self
    {
        return new self(
            $row['id'],
            $row['numero'],
            $row['dateSeance']->format('d/m/Y'),
            (int) $row['totalCollecte'],
            (int) $row['totalAmendes'],
            (int) $row['totalCaisse'],
        );
    }
}
