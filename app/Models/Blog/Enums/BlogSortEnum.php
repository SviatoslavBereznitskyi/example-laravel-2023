<?php

declare(strict_types=1);

namespace App\Models\Blog\Enums;

enum BlogSortEnum: string
{
    case SortLatest = 'latest';
    case SortOldest = 'oldest';

    public const CASES = [
        'latest',
        'oldest',
    ];
}
