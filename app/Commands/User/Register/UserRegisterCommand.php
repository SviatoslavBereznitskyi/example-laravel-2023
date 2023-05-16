<?php

declare(strict_types=1);

namespace App\Commands\User\Register;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(schema: self::class, required: ['password'])]
class UserRegisterCommand
{
    #[Assert\Email(mode: 'strict')]
    #[OA\Property(format: 'email')]
    #[Assert\NotBlank]
    public ?string $email = null;

    #[OA\Property()]
    #[Assert\NotBlank]
    public ?string $phone = null;

    #[Assert\NotBlank]
    #[OA\Property()]
    public string $password;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public string $id;
}
