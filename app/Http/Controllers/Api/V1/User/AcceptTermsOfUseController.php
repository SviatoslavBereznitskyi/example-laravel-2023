<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Commands\User\AcceptTermsOfUse\AcceptTermsOfUseCommand;
use App\Commands\User\AcceptTermsOfUse\AcceptTermsOfUseCommandHandler;
use App\Validator\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class AcceptTermsOfUseController
{
    public function __construct(private AcceptTermsOfUseCommandHandler $handler, private Validator $validator)
    {
    }

    #[OA\Patch(path: 'term-of-use/accept', operationId: 'AcceptTermsOfUse', tags: ['User'], security: [['bearerAuth' => []]])]
    #[OA\Response(response: Response::HTTP_OK, description: 'Ok', content: new OA\JsonContent())]
    #[OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad Request', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(Request $request)
    {
        $command = new AcceptTermsOfUseCommand();

        $command->userId = Auth::user()->id;

        $this->validator->validate($command);

        $this->handler->handle($command);

        return response()->noContent(Response::HTTP_OK);
    }
}
