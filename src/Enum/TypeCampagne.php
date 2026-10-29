<?php

namespace App\Enum;

enum TypeCampagne: string
{
    case EPARGNE_CALEBASSE = 'epargne_calebasse';
    case TONTINE = 'tontine';
    case PRET = 'pret';

    public function label(): string
    {
        return match ($this) {
            self::EPARGNE_CALEBASSE => 'Épargne calebasse',
            self::TONTINE => 'Tontine',
            self::PRET => 'Prêt',
        };
    }
}
