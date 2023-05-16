<?php

declare(strict_types=1);

namespace App\Exceptions\Catalog\Company\ResidentialComplex\Apartment;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Throwable;

class ClaimApartmentDuplicateException extends ConflictHttpException
{
    public function __construct(
        string $message = 'Claim apartment duplicate',
        int $code = 409,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $previous, $code);
    }
}
