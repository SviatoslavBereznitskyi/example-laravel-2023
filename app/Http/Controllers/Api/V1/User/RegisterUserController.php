<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Commands\User\CreateWallet\CreateWalletCommand;
use App\Commands\User\CreateWallet\CreateWalletCommandHandler;
use App\Commands\User\Register\UserRegisterCommand;
use App\Commands\User\Register\UserRegisterCommandHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\RegisterUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class RegisterUserController extends Controller
{
    public function __construct(
        private UserRegisterCommandHandler $handler,
        private DenormalizerInterface $denormalizer,
        private CreateWalletCommandHandler $createWalletCommandHandler
    ) {
    }

    #[OA\Post(path: '/users/register', operationId: 'RegisterUser', tags: ['User'])]
    #[OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/' . UserRegisterCommand::class))]
    #[OA\Response(response: \Illuminate\Http\Response::HTTP_CREATED, description: 'Created', content: new OA\JsonContent())]
    #[OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad Request', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(RegisterUserRequest $request): Response
    {
        /** @var UserRegisterCommand $command */
        $command = $this->denormalizer->denormalize($request->validated(), UserRegisterCommand::class);
        $command->id = Str::uuid()->toString();
        DB::beginTransaction();
        $this->handler->handle($command);

        $createWalletCommand = new CreateWalletCommand();
        $createWalletCommand->userId = $command->id;

        $this->createWalletCommandHandler->handle($createWalletCommand);
        DB::commit();

        return response()->noContent(Response::HTTP_CREATED);
    }
}
