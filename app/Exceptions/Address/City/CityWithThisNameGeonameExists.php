<?php

declare(strict_types=1);

namespace App\Exceptions\Address\City;

use DomainException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CityWithThisNameGeonameExists extends DomainException
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
