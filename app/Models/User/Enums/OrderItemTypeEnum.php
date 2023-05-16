<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum OrderItemTypeEnum: string
{
    case GOLDEN_POINT = 'golden_point';
    case SILVER_POINT = 'silver_point';
    case EXCHANGE = 'exchange';
    case CHANGE_EXCHANGE_LIMIT = 'change_exchange_limit';
    case ACTUALIZE = 'actualize_limit';
    case RAISE = 'raise';

    public const CASES = [
        'golden_point',
        'silver_point',
    ];
}
