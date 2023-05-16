<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum PermissionEnum: string
{
    case ReadApartments = 'read_apartments';
    case EditApartments = 'edit_apartments';
    case CreateApartments = 'create_apartments';
    case AccessAdminPanel = 'access_admin_panel';
    case AddModerators = 'add_moderators';
    case RemoveModerators = 'remove_moderators';
    case ViewModerators = 'view_moderators';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->name;
        }

        return $array;
    }
}
