<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Commands\User\CreateFeedbackMessage\UserCreateFeedbackMessageCommand;
use App\Commands\User\CreateFeedbackMessage\UserCreateFeedbackMessageCommandHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\FeedbackMessageRequest;
use App\Validator\Validator;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class SendFeedbackMessageController extends Controller
{
    public function __construct(
        private UserCreateFeedbackMessageCommandHandler $handler,
        public DenormalizerInterface $denormalizer,
        private Validator $validator
    ) {
    }

    #[OA\Post(path: 'users/feedback-message/send', operationId: 'SendFeedbackMessage', security: [['bearerAuth' => []]], tags: ['User.FeedbackMessage'], )]
    #[OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/' . UserCreateFeedbackMessageCommand::class))]
    #[OA\Response(response: \Symfony\Component\HttpFoundation\Response::HTTP_NO_CONTENT, description: 'Ok')]
    #[OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad Request', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(FeedbackMessageRequest $request): Response
    {
        /** @var UserCreateFeedbackMessageCommand $command */
        $command = $this->denormalizer->denormalize($request->validated(), UserCreateFeedbackMessageCommand::class);

        $this->validator->validate($command);

        $this->handler->handle($command);

        return response()->noContent();
    }
}
