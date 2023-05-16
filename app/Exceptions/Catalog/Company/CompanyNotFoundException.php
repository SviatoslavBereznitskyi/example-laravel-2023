<?php

declare(strict_types=1);

namespace App\Exceptions\Catalog\Company;

use DomainException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CompanyNotFoundException extends DomainException
{
    public function render($request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], Response::HTTP_NOT_FOUND);
    }
}
