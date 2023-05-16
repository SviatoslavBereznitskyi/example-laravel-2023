<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum MessageSortEnum: string
{
    case Date = 'date';
    case DateDESC = 'dateDESC';

    public static function getList(): array
    {
        return array_map(static fn ($item) => $item->value, self::cases());
    }
}
