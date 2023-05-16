<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class UserPasswordException extends HttpException
{
    public function __construct(
        string $message = '',
        int $code = 422,
        ?Throwable $previous = null
    ) {
        parent::__construct($code, $message, $previous);
    }
}
