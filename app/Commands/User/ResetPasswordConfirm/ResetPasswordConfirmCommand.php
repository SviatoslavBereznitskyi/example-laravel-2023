<?php

declare(strict_types=1);

namespace App\Commands\User\ResetPasswordConfirm;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(schema: self::class)]
class ResetPasswordConfirmCommand
{
    #[Assert\Email(mode: 'strict')]
    #[OA\Property()]
    #[Assert\NotBlank]
    public string $password;

    #[Assert\Email(mode: 'strict')]
    #[OA\Property()]
    #[Assert\NotBlank]
    public string $confirmPassword;

    #[OA\Property()]
    #[Assert\NotBlank]
    public string $code;
}
