<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum ManageTypeEnum: string
{
    case DIRECTOR = 'director';
    case MANAGER = 'manager';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->name;
        }

        return $array;
    }
}
