<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User\Dialogue;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DialoguePolicy
{
    use HandlesAuthorization;

    public const ACTION_VIEW = 'view';
    public const ACTION_MARKER = 'marker';
    public const ACTION_UN_MARKER = 'unMarker';
    public const ACTION_ARCHIVE = 'archive';
    public const ACTION_UN_ARCHIVE = 'unArchive';

    public function view(User $user, Dialogue $dialogue): bool
    {
        return $user->id === $dialogue->user->id || $user->id === $dialogue->apartment->user->id;
    }

    public function marker(User $user, Dialogue $dialogue): bool
    {
        return $user->id === $dialogue->user->id || $user->id === $dialogue->apartment->user->id;
    }

    public function unMarker(User $user, Dialogue $dialogue): bool
    {
        return $user->id === $dialogue->user->id || $user->id === $dialogue->apartment->user->id;
    }

    public function archive(User $user, Dialogue $dialogue): bool
    {
        return $user->id === $dialogue->user->id || $user->id === $dialogue->apartment->user->id;
    }

    public function unArchive(User $user, Dialogue $dialogue): bool
    {
        return $user->id === $dialogue->user->id || $user->id === $dialogue->apartment->user->id;
    }
}
