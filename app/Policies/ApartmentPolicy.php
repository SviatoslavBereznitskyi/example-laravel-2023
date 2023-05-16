<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Catalog\Apartment;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApartmentPolicy
{
    use HandlesAuthorization;

    public const ACTION_EDIT = 'edit';
    public const ACTION_PUBLISHED = 'published';
    public const ACTION_TO_PENDING = 'toPending';
    public const ACTION_UNPUBLISHED = 'unpublished';
    public const ACTION_REJECTED = 'rejected';
    public const ACTION_IMAGE = 'image';
    public const ACTION_ADD_STATISTIC = 'addStatistic';
    public const ACTION_DELETE = 'delete';
    public const ACTION_CLIME = 'claim';

    public function edit(User $user, Apartment $apartment): bool
    {
        return $apartment->user->id === $user->id || $apartment->user->company_id === $user->company_id;
    }

    public function published(User $user, Apartment $apartment): bool
    {
        return $apartment->user->id === $user->id || $apartment->user->company_id === $user->company_id;
    }

    public function unpublished(User $user, Apartment $apartment): bool
    {
        return $apartment->user->id === $user->id || $apartment->user->company_id === $user->company_id;
    }

    public function image(User $user, Apartment $apartment): bool
    {
        return $apartment->user->id === $user->id || $apartment->user->company_id === $user->company_id;
    }

    public function toPending(User $user, Apartment $apartment): bool
    {
        return $apartment->user->id === $user->id || $apartment->user->company_id === $user->company_id;
    }

    public function addStatistic(User $user, Apartment $apartment): bool
    {
        return $apartment->user->id === $user->id || $apartment->user->company_id === $user->company_id;
    }

    public function delete(User $user, Apartment $apartment): bool
    {
        return $apartment->user->id === $user->id || $apartment->user->company_id === $user->company_id;
    }

    public function claim(User $user, Apartment $apartment): bool
    {
        return $apartment->user->id !== $user->id && $apartment->user->company_id !== $user->company_id;
    }
}
