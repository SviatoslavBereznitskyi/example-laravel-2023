<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth\OAuth;

use App\Commands\SocialUser\Create\SocialUserCreateCommand;
use App\Commands\SocialUser\Create\SocialUserCreateCommandHandler;
use App\Commands\User\Create\UserCreateCommand;
use App\Commands\User\Create\UserCreateCommandHandler;
use App\Commands\User\CreateWallet\CreateWalletCommand;
use App\Commands\User\CreateWallet\CreateWalletCommandHandler;
use App\Http\Controllers\Controller;
use App\Repositories\User\SocialUserRepository;
use App\Repositories\User\UserRepository;
use App\Validator\Validator;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;
use OpenApi\Attributes as OA;

class SocialLoginController extends Controller
{
    public function __construct(
        private UserRepository $userRepository,
        private SocialUserRepository $socialUserRepository,
        private UserCreateCommandHandler $userCreateCommandHandler,
        private SocialUserCreateCommandHandler $socialUserCreateCommandHandler,
        private CreateWalletCommandHandler $createWalletCommandHandler,
        private Validator $validator
    ) {
    }

    #[OA\Post(path: '/auth/{driver}/callback', operationId: 'SocialAuth', tags: ['OAuth'])]
    #[OA\Response(response: Response::HTTP_OK, description: 'Ok', content: new OA\JsonContent(ref: '#/components/schemas/TokenResponse'))]
    #[OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad Request', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(string $driver): JsonResponse
    {
        /** @var User $userSocial */
        $userSocial = Socialite::driver($driver)->stateless()->user();
        $facebookId = null;

        if ($driver === 'facebook') {
            $facebookId = $userSocial?->id;
        }

        $isNew = false;

        $internalUserSocial = $this->socialUserRepository->findBySocialIdAndProvider($userSocial->getId(), $driver);

        if ($internalUserSocial) {
            $user = $internalUserSocial->user;
        } else {
            $user = null;

            if ($userSocial->email) {
                $user = $this->userRepository->getByCredentials($userSocial->getEmail(), null, $facebookId);
            }

            if (!$user) {
                $isNew = true;
                $command = new UserCreateCommand();
                $command->email = $userSocial->getEmail();
                $command->name = $userSocial->getName();
                $command->id = Str::uuid()->toString();
                $command->facebookId = $facebookId;

                $this->validator->validate($command);

                $this->userCreateCommandHandler->handle($command);

                $createWalletCommand = new CreateWalletCommand();
                $createWalletCommand->userId = $command->id;

                $this->createWalletCommandHandler->handle($createWalletCommand);

                $user = $this->userRepository->getById($command->id);
            }

            $command = new SocialUserCreateCommand();
            $command->socialId = $userSocial->getId();
            $command->userId = $user->getKey();
            $command->id = Str::uuid()->toString();
            $command->provider = $driver;
            $command->username = $userSocial->name;

            $this->validator->validate($command);

            $this->socialUserCreateCommandHandler->handle($command);
        }

        $token = $user->createToken($driver);

        return response()->json([
            'tokenType' => 'Bearer',
            'accessToken' => $token->accessToken,
            'expiresIn' => Carbon::now()->diffInSeconds($token->token->expires_at),
            'isNew' => $isNew,
        ]);
    }
}
