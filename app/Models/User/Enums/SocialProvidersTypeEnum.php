<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum SocialProvidersTypeEnum: string
{
    case Google = 'google';
    case Facebook = 'facebook';
}
