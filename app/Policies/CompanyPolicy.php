<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Catalog\Company\Company;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public const ACTION_EDIT = 'edit';
    public const ACTION_DELETE = 'delete';
    public const ACTION_LOGO = 'logo';
    public const ACTION_CALL = 'call';

    public function edit(User $user, Company $company): bool
    {
        return $user->company_id === $company->id;
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->company_id === $company->id;
    }

    public function logo(User $user, Company $company): bool
    {
        return $user->company_id === $company->id;
    }

    public function call(User $user, Company $company): bool
    {
        return $user->company_id === $company->id;
    }
}
