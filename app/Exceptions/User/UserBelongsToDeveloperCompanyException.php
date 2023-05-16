<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class UserBelongsToDeveloperCompanyException extends HttpException
{
    public function __construct(
        string $message = 'This user belongs to the developer\'s company.',
        int $code = 409,
        ?Throwable $previous = null
    ) {
        parent::__construct($code, $message, $previous);
    }
}
