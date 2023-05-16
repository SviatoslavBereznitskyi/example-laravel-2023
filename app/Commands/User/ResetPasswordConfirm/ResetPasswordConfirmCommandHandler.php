<?php

declare(strict_types=1);

namespace App\Commands\User\ResetPasswordConfirm;

use App\Exceptions\User\UserPasswordException;
use App\Models\User\Enums\OtpCodeTypeEnum;
use App\Models\User\OtpCode;
use App\Repositories\User\OtpCodeRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResetPasswordConfirmCommandHandler
{
    public function __construct(private OtpCodeRepository $otpCodeRepository)
    {
    }

    public function handle(ResetPasswordConfirmCommand $command): void
    {
        /** @var OtpCode $code */
        $code = $this->otpCodeRepository->getActiveByCodeAndType($command->code, OtpCodeTypeEnum::PasswordReset);

        if (!$code) {
            throw new NotFoundHttpException('Code is invalid');
        }

        if ($command->password !== $command->confirmPassword) {
            throw new UserPasswordException(__('exceptions.password_and_confirm_not_same'));
        }

        $user = $code->user;

        DB::beginTransaction();
        $user->changePassword($command->password)->save();

        $code->delete();
        DB::commit();
    }
}
