<?php

declare(strict_types=1);

namespace App\Exceptions\Settings;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExcengeRateNotFoundException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Exchange Rate not found',
        int $code = 404,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $previous, $code);
    }
}
