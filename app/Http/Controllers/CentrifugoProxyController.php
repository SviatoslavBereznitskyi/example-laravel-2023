<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\NotificationManager;
use App\OpenApi\V1\Websocket\ConnectionResponse;
use App\Services\CentrifugoNotificationService;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use OpenApi\Attributes as OA;

class CentrifugoProxyController extends Controller
{
    public function __construct(private Centrifugo $centrifugo)
    {
    }

    #[OA\Get(path: '/centrifugo/connect', operationId: 'ContrifugoConnect', servers: [
        new OA\Server(
            url: WS_API_V1_ENTRYPOINT,
            description: 'server for websockets'
        ),
    ], tags: ['Websockets'])]
    #[OA\Response(response: Response::HTTP_SWITCHING_PROTOCOLS, description: 'Ok', content: new OA\JsonContent(ref: '#/components/schemas/' . ConnectionResponse::class))]
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->cookies->has('token')) {
            $user = JWTAuth::setToken($request->cookies->get('token'))->toUser();

            $channels = [
                'personal.' . $user?->id,
            ];
            foreach (CentrifugoNotificationService::getAvailableRooms() as $room) {
                $channels[] = $room . '.' . $user?->id;
            }
        }

        $channels[] = NotificationManager::RAFFLE_ROOM . ':#' . NotificationManager::TICKET_BUYING;
        $channels[] = NotificationManager::RAFFLE_ROOM . ':#' . NotificationManager::CHARITY_ROOM;

        return new JsonResponse([
            'result' => [
                'user' => isset($user) ? $user->id : null,
                'channels' => $channels,
            ],
        ]);
    }
}
