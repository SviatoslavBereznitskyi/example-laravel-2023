<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum SexEnum: string
{
    case Male = 'male';
    case Female = 'female';
    case Other = 'other';

    public const CASES = [
        'male',
        'female',
        'other',
    ];
}
