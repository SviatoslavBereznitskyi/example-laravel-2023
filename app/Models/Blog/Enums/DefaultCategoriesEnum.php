<?php

declare(strict_types=1);

namespace App\Models\Blog\Enums;

enum DefaultCategoriesEnum: string
{
    case Charity = 'charity';
    case Advice = 'advice';

    public const CASES = [
        'charity',
        'advice',
    ];
}
