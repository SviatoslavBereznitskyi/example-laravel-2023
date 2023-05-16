<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Catalog\Agency\Agency;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgencyPolicy
{
    use HandlesAuthorization;

    public const ACTION_EDIT = 'edit';
    public const ACTION_DELETE = 'delete';
    public const ACTION_IMAGE = 'image';
    public const ACTION_LOGO = 'logo';
    public const ACTION_CALL = 'call';

    public function edit(User $user, Agency $agency): bool
    {
        return $agency->users->where('id', $user->id)->isNotEmpty();
    }

    public function delete(User $user, Agency $agency): bool
    {
        return $agency->users->where('id', $user->id)->isNotEmpty();
    }

    public function image(User $user, Agency $agency): bool
    {
        return $agency->users->where('id', $user->id)->isNotEmpty();
    }

    public function logo(User $user, Agency $agency): bool
    {
        return $agency->users->where('id', $user->id)->isNotEmpty();
    }

    public function call(User $user, Agency $agency): bool
    {
        return $agency->users->where('id', $user->id)->isNotEmpty();
    }
}
