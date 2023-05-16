<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth\OAuth;

use App\Commands\SocialUser\Create\SocialUserCreateCommandHandler;
use App\Commands\User\Create\UserCreateCommandHandler;
use App\Http\Controllers\Controller;
use App\Repositories\User\SocialUserRepository;
use App\Repositories\User\UserRepository;
use App\Validator\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;
use OpenApi\Attributes as OA;

class SocialLoginGetRedirectController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
        private SocialUserRepository $socialUserRepository,
        private UserCreateCommandHandler $userCreateCommandHandler,
        private SocialUserCreateCommandHandler $socialUserCreateCommandHandler,
        private Validator $validator
    ) {
    }

    #[OA\Get(path: '/auth/{driver}', operationId: 'SocialAuthGetRedirect', tags: ['OAuth'])]
    #[OA\Response(response: Response::HTTP_OK, description: 'Ok', content: new OA\JsonContent(properties: [
        new OA\Property(
            property: 'url',
            type: 'string',
            format: 'uri',
        ),
    ]))]
    #[OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad Request', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(string $driver, Request $request): JsonResponse
    {
        return response()->json([
            'url' => Socialite::driver($driver)
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }
}
