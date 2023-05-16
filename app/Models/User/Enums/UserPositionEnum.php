<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum UserPositionEnum: string
{
    case DirectorCompany = 'director';
    case ManageCompany = 'manager';
    case HeadAgency = 'head';
    case RealtorAgency = 'realtor';
    case PrivateRealtor = 'private-realtor';
    case PrivatePerson = 'private-person';

    public const TRANS_PATH = 'enums.userPosition.';

    public static function getTranslateCases(): array
    {
        return array_map(static fn ($item) => [$item->value => __(self::TRANS_PATH . $item->value)], self::cases());
    }

    public static function getList(): array
    {
        return array_map(static fn ($item) => $item->value, self::cases());
    }
}
