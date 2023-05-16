<?php

declare(strict_types=1);

namespace App\Models\Blog\Enums;

enum BlogCategoriesEnum: string
{
    case Raffle = 'raffle';
    case BlogCharity = 'blog-charity';

    public const CASES = [
        'raffle',
        'blog-charity',
    ];
}
