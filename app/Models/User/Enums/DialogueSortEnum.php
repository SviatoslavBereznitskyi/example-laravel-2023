<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum DialogueSortEnum: string
{
    case Latest = 'latest';
    case Oldest = 'oldest';

    public static function getList(): array
    {
        return array_map(static fn ($item) => $item->value, self::cases());
    }
}
