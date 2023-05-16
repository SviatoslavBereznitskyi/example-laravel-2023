<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class UserWithSocialAccountExistsException extends HttpException
{
    public function __construct(
        string $message = 'User with this social account exists',
        int $code = 422,
        ?Throwable $previous = null
    ) {
        parent::__construct($code, $message, $previous);
    }
}
