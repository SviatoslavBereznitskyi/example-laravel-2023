<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum AgencyManageTypeEnum: string
{
    case HEAD = 'head';
    case REALTOR = 'realtor';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->name;
        }

        return $array;
    }
}
