<?php

declare(strict_types=1);

namespace App\Exceptions\Address\Country;

use DomainException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class WrongCountryGeonameId extends DomainException
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
