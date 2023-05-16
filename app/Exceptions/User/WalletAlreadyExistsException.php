<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class WalletAlreadyExistsException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Wallet exists',
        int $code = 422,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $previous, $code);
    }
}
