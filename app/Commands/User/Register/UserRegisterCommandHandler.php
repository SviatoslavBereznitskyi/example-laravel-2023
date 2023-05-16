<?php

declare(strict_types=1);

namespace App\Commands\User\Register;

use App\Exceptions\User\UserWithThisCredentialsAlreadyExists;
use App\Models\Settings\ExchangeLimit;
use App\Models\User\User;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserRegisterCommandHandler
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function handle(UserRegisterCommand $command): void
    {
        if ($this->userRepository->getByCredentials($command->email, $command->phone)) {
            throw new UserWithThisCredentialsAlreadyExists();
        }

        $user = new User();

        $user->id = $command->id;
        $user->email = $command->email;
        $user->phone = $command->phone;
        $user->password = Hash::make($command->password);
        $user->exchange_limit = ExchangeLimit::DEFAULT;

        $user->save();
    }
}
