<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User\User;

interface SocialChecker
{
    public function authorize(User $user): void;

    public function check(string $objectId): bool;
}
