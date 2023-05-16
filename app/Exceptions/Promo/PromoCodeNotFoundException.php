<?php

declare(strict_types=1);

namespace App\Exceptions\Promo;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class PromoCodeNotFoundException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Code not found',
        int $code = 404,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $previous, $code);
    }
}
