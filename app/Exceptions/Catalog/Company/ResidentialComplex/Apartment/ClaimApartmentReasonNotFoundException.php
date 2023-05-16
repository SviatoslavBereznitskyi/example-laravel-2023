<?php

declare(strict_types=1);

namespace App\Exceptions\Catalog\Company\ResidentialComplex\Apartment;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ClaimApartmentReasonNotFoundException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'Claim reason not found',
        int $code = 404,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $previous, $code);
    }
}
