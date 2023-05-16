<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User\Message;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public const ACTION_EDIT = 'edit';
    public const ACTION_IMAGE = 'image';
    public const ACTION_CLIME = 'claim';

    public function edit(User $user, Message $message): bool
    {
        return $user->id === $message->userFrom->id;
    }

    public function claim(User $user, Message $message): bool
    {
        return $user->id === $message->userTo->id;
    }

    public function image(User $user, Message $message): bool
    {
        return $user->id === $message->userFrom->id;
    }
}
