<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum OtpCodeTypeEnum: string
{
    case EmailConfirm = 'emailConfirm';
    case PhoneConfirm = 'phoneConfirm';
    case EmailChange = 'emailChange';
    case PhoneChange = 'phoneChange';
    case PasswordReset = 'passwordReset';
}
