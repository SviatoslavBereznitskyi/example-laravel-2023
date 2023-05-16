<?php

declare(strict_types=1);

namespace App\Exceptions\Settings;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class DeleteReasonNotFoundException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Delete reason not found',
        int $code = 404,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $previous, $code);
    }
}
