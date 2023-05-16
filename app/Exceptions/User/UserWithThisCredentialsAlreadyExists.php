<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use DomainException;
use Throwable;

class UserWithThisCredentialsAlreadyExists extends DomainException
{
    public function __construct(
        string $message = 'User with this credentials already exists',
        int $code = 422,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
