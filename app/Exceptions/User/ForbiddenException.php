<?php

declare(strict_types=1);

namespace App\Exceptions\User;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ForbiddenException extends ConflictHttpException
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!empty($response->exception) && $response->exception instanceof AuthorizationException) {
            return response()->json(['message' => __('exceptions.forbidden')], JsonResponse::HTTP_FORBIDDEN);
        }

        return $response;
    }
}
