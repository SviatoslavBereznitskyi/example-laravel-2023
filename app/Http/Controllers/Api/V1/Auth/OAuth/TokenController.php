<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth\OAuth;

use App\Models\User\User;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use OpenApi\Attributes as OA;
use Psr\Http\Message\ServerRequestInterface;

class TokenController extends AccessTokenController
{
    #[OA\Post(path: '/oauth/token', operationId: 'OAuthToken', tags: ['OAuth'])]
    #[OA\RequestBody(content: new OA\JsonContent(ref: '#/components/schemas/AccessTokenRequest'))]
    #[OA\Response(response: Response::HTTP_OK, description: 'Ok', content: new OA\JsonContent(ref: '#/components/schemas/TokenResponse'))]
    #[OA\Response(response: Response::HTTP_BAD_REQUEST, description: 'Bad Request', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    #[OA\Response(response: Response::HTTP_UNAUTHORIZED, description: 'Unauthorized', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(ServerRequestInterface $request): JsonResponse
    {
        $rememberMe = (bool)(isset($request->getParsedBody()['rememberMe']) ? $request->getParsedBody()['rememberMe'] : false);
        if ($rememberMe === false) {
            $lifetime = new DateInterval(User::EXPIRED_IN_TOKEN);
            resolve(AuthorizationServer::class)
                ->enableGrantType(
                    new PasswordGrant(
                        resolve(UserRepository::class),
                        resolve(RefreshTokenRepository::class)
                    ),
                    $lifetime
                );
            Passport::refreshTokensExpireIn(Carbon::now()->addMinutes(120));
            Passport::tokensExpireIn(Carbon::now()->addDay());
        }
        $request = $request->withParsedBody([
            'grant_type' => 'password',
            'client_id' => config('passport.password_grant_client.id'),
            'client_secret' => config('passport.password_grant_client.secret'),
            'scope' => '',
            'username' => Str::lower($request->getParsedBody()['email'] ?? $request->getParsedBody()['phone']),
            'password' => $request->getParsedBody()['password'] ?? '',
        ]);

        return response()->json($this->convertToCamel(json_decode(parent::issueToken($request)->getContent(), true)));
    }

    private function convertToCamel(array $responseData): array
    {
        $response = [];
        foreach ($responseData as $key => $value) {
            $response[Str::camel($key)] = $value;
        }

        return $response;
    }
}
