<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum AchievementEnum: string
{
    case FIRST_SWALLOW = 'first_swallow';
    case POPULARITY = 'popularity';
    case REGULAR = 'regular';
    case REBIRTH = 'rebirth';
    case DAILY = 'daily';
    case DOCUMENTS = 'documents';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->name;
        }

        return $array;
    }
}
