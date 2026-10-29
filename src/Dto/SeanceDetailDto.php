<?php

namespace App\Dto;

use App\Entity\Amende;
use App\Entity\Seance;

final readonly class SeanceDetailDto
{
    /**
     * @param CotisationLigneDto[] $cotisations
     * @param AmendeLigneDto[]     $amendes
     */
    public function __construct(
        public int $id,
        public int $numero,
        public string $date,
        public int $campagneId,
        public string $campagneNom,
        public array $cotisations,
        public array $amendes,
        public int $totalCollecte,
        public int $totalCaisse,
        public int $totalAmendes,
    ) {
    }

    /** @param Amende[] $amendes */
    public static function fromEntities(Seance $s, array $amendes): self
    {
        $cotisations = array_map(CotisationLigneDto::fromEntity(...), $s->getCotisations()->toArray());
        $lignesAmendes = array_map(AmendeLigneDto::fromEntity(...), $amendes);

        return new self(
            $s->getId(),
            $s->getNumero(),
            $s->getDateSeance()->format('d/m/Y'),
            $s->getCampagne()->getId(),
            $s->getCampagne()->getNom(),
            $cotisations,
            $lignesAmendes,
            array_sum(array_map(fn (CotisationLigneDto $c) => $c->montantEpargne, $cotisations)),
            array_sum(array_map(fn (CotisationLigneDto $c) => $c->montantCaisse, $cotisations)),
            array_sum(array_map(fn (AmendeLigneDto $a) => $a->montant, $lignesAmendes)),
        );
    }
}
