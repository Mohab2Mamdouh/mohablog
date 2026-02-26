<?php

namespace App\Enums;

enum SkillType: string
{
    case Backend = 'Backend';
    case Frontend = 'Frontend';
    case Database = 'Database';
    case PriorKnowledge = 'Prior Knowledge';
    case LittleKnowledge = 'Little Knowledge';
    case OtherSkills = 'Other Skills';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

