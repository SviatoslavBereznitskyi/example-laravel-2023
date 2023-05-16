<?php

declare(strict_types=1);

namespace App\Commands\User\ResetPassword;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(schema: self::class)]
class ResetPasswordCommand
{
    #[Assert\Email(mode: 'strict')]
    #[OA\Property(format: 'email')]
    #[Assert\NotBlank]
    public ?string $email = null;

    #[OA\Property()]
    #[Assert\NotBlank]
    public ?string $phone = null;
}
