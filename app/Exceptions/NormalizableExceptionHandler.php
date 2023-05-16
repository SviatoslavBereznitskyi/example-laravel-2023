<?php

declare(strict_types=1);

namespace App\Exceptions;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class NormalizableExceptionHandler
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!empty($response->exception) && $response->exception instanceof NotNormalizableValueException) {
            return response()->json(['message' => $response->exception->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }

        return $response;
    }
}
