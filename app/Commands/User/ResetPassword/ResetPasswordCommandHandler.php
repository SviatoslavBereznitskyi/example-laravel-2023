<?php

declare(strict_types=1);

namespace App\Commands\User\ResetPassword;

use App\Models\User\Enums\OtpCodeTypeEnum;
use App\Notifications\User\ResetPassword\ResetPasswordMailNotification;
use App\Notifications\User\ResetPassword\ResetPasswordSmsNotification;
use App\Repositories\User\OtpCodeRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Str;

class ResetPasswordCommandHandler
{
    public function __construct(private UserRepository $userRepository, private OtpCodeRepository $otpCodeRepository)
    {
    }

    public function handle(ResetPasswordCommand $command): void
    {
        $user = $this->userRepository->getByCredentials(Str::lower($command->email), $command->phone);

        if (null === $user) {
            throw new ModelNotFoundException('User not found');
        }

        $code = $this->otpCodeRepository->createOtpForUser($user->getKey(), OtpCodeTypeEnum::PasswordReset);

        if ($command->email) {
            $user->notify((new ResetPasswordMailNotification($code->code))->onQueue('notify'));
        } else {
            $user->notify((new ResetPasswordSmsNotification($code->code))->onQueue('notify'));
        }
    }
}
