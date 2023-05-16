<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum MessageNotificationTypeEnum: string
{
    case Message = 'message';
    case File = 'file';
    case Viewed = 'viewed';

    public static function getList(): array
    {
        return array_map(static fn ($item) => $item->value, self::cases());
    }
}
