<?php

namespace App\Enum;

enum StatutPresence: string
{
    case PRESENT = 'present';
    case ABSENT_REPRESENTE = 'absent_represente';
    case ABSENT_NON_PAYE = 'absent_non_paye';

    public function label(): string
    {
        return match ($this) {
            self::PRESENT => 'Présent',
            self::ABSENT_REPRESENTE => 'Absent (représenté)',
            self::ABSENT_NON_PAYE => 'Absent (non payé)',
        };
    }
}
