<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Throwable;

class ClaimMessageDuplicateException extends ConflictHttpException
{
    public function __construct(
        string $message = 'Claim message duplicate',
        int $code = 409,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $previous, $code);
    }
}
