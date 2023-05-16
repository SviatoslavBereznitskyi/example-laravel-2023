<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth\OAuth;

use Illuminate\Http\Response;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use OpenApi\Attributes as OAT;
use Psr\Http\Message\ServerRequestInterface;

class TokenRefreshController extends AccessTokenController
{
    #[OAT\Post(path: '/oauth/token/refresh', operationId: 'OAuthTokenRefresh', tags: ['OAuth'])]
    #[OAT\RequestBody(content: new OAT\JsonContent(ref: '#/components/schemas/RefreshTokenRequest'))]
    #[OAT\Response(response: Response::HTTP_OK, description: 'Ok', content: new OAT\JsonContent(ref: '#/components/schemas/TokenResponse'))]
    #[OAT\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad Request', content: new OAT\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OAT\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized', content: new OAT\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(ServerRequestInterface $request): Response
    {
        $request = $request->withParsedBody([
            'grant_type' => 'refresh_token',
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
            'scope' => '',
            'refresh_token' => $request->getParsedBody()['refreshToken'] ?? '',
        ]);

        return parent::issueToken($request);
    }
}
