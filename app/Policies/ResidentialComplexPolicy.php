<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Catalog\Company\Company;
use App\Models\Catalog\Company\ResidentialComplex\ResidentialComplex;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResidentialComplexPolicy
{
    use HandlesAuthorization;

    public const ACTION_CREATE = 'create';
    public const ACTION_EDIT = 'edit';
    public const ACTION_DELETE = 'delete';
    public const ACTION_IMAGE = 'image';
    public const ACTION_DOCUMENT = 'document';

    public function create(User $user, ResidentialComplex $complex, Company $company): bool
    {
        return $company->users->where('id', $user->id)->isNotEmpty();
    }

    public function edit(User $user, ResidentialComplex $complex): bool
    {
        return $complex->company->users->where('id', $user->id)->isNotEmpty();
    }

    public function delete(User $user, ResidentialComplex $complex): bool
    {
        return $complex->company->users->where('id', $user->id)->isNotEmpty();
    }

    public function image(User $user, ResidentialComplex $complex): bool
    {
        return $complex->company->users->where('id', $user->id)->isNotEmpty();
    }

    public function document(User $user, ResidentialComplex $complex): bool
    {
        return $complex->company->users->where('id', $user->id)->isNotEmpty();
    }
}
