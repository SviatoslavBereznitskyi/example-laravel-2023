<?php

declare(strict_types=1);

namespace App\OpenApi\V1;

use OpenApi\Attributes as OAT;

#[OAT\Info(
    version: '1.0.0',
    description: 'HTTP JSON API',
    title: 'ESTATO',
    x: [
    ]
)]
#[OAT\SecurityScheme(
    securityScheme: 'bearerAuth',
    type: 'oauth2',
    description: 'Authorization: Bearer {access-token}',
    name: 'Authorization',
    in: 'header',
    bearerFormat: 'JWT',
    scheme: 'Bearer',
    flows: [
        new OAT\Flow(
            tokenUrl: TOKEN_OAUTH2_ACTION,
            refreshUrl: TOKEN_REFRESH_OAUTH2_ACTION,
            flow: 'password',
            scopes: []
        ),
    ]
),
]
#[OAT\Parameter(
    parameter: 'headers--Accept-Language',
    name: 'Accept-Language',
    in: 'header',
    required: false,
    schema: new OAT\Schema(type: 'string', enum: ['en', 'pl', 'ru', 'uk'])
)]
#[OAT\OpenApi(
    x: [
        'tagGroups' => [
            [
                'name' => 'OAuth',
                'tags' => ['OAuth'],
            ], [
                'name' => 'JWT',
                'tags' => ['JWT'],
            ],
            [
                'name' => 'User',
                'tags' => ['User', 'User.Current', 'User.Current.Notifications', 'User.Documents', 'User.Orders', 'User.Transactions', 'User.FeedbackMessage', 'User.Subscriptions', 'User.Current.Subscriptions', 'User.Messages'],
            ],
        ],
    ]
)]
#[OAT\Server(
    url: API_V1_ENTRYPOINT,
    description: 'Api ESTATO'
)]
#[OAT\PathItem(
    path: '/api/v1/',
    servers: [
    ]
)]
#[OAT\Schema(
    schema: 'ErrorResponse',
    properties: [
        new OAT\Property(property: 'message', type: 'string'),
    ],
    type: 'object'
)]
#[OAT\Tag(name: 'OAuth', description: 'Methods for oauth.')]
#[OAT\Tag(name: 'JWT', description: 'Methods for jwt auth.')]
#[OAT\Tag(name: 'User')]
class OpenApi
{
}
