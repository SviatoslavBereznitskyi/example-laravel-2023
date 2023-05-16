<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum RoleEnum: string
{
    // Super Admin
    case Admin = 'admin';

    // Company (developers) roles
    case Director = 'director';
    case Manager = 'manager';

    // Agency roles
    case Head = 'head';
    case Realtor = 'realtor';

    // Infrastructure role
    case InfrastructureManager = 'infrastructure manager';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->name;
        }

        return $array;
    }
}
