<?php

declare(strict_types=1);

namespace App\Exceptions\Settings;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class DefaultExchangeLimitNotFoundException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Default exchange limit not set',
        int $code = 404,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $previous, $code);
    }
}
