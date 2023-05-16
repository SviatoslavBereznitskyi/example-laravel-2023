<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserShortResource;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class GetUserByIdController extends Controller
{
    public function __construct(private UserRepository $repository)
    {
    }

    #[OA\Get(
        path: '/users/{userId}/info',
        operationId: 'GetUserById',
        tags: ['User'],
        parameters: [
            new OA\Parameter(name: 'userId', in: 'path', required: true, schema: new OA\Schema(type: 'string', format: 'uuid', example: '1da2e2c6-e904-4350-9c1e-d8fdcaaf7a99')),
        ]
    )]
    #[OA\Response(response: \Symfony\Component\HttpFoundation\Response::HTTP_OK, description: 'Ok', content: new OA\JsonContent(ref: '#/components/schemas/' . UserShortResource::class))]
    #[OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad Request', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(string $userId): JsonResource
    {
        return UserShortResource::make($this->repository->with(['agency.district', 'agency.street.city.division', 'company'])->find($userId));
    }
}
