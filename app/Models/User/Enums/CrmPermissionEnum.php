<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum CrmPermissionEnum: string
{
    case ApartmentCreate = 'crm.apartment.create';
    case ApartmentEdit = 'crm.apartment.edit';
    case ApartmentDeActivate = 'crm.apartment.de-activate';
    case ApartmentDelete = 'crm.apartment.delete';
    case ApartmentPublic = 'crm.apartment.public';
    case ApartmentPending = 'crm.apartment.pending';
    case Infrastructure = 'crm.infrastructure';
    case CompanyManage = 'crm.company.manage';
    case AgencyManage = 'crm.agency.manage';

    public static function toArray()
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->name;
        }

        return $array;
    }
}
