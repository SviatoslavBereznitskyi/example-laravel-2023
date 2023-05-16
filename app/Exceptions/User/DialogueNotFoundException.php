<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class DialogueNotFoundException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Dialogue not found',
        int $code = 404,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $previous, $code);
    }
}
