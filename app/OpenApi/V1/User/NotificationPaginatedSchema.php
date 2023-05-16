<?php

declare(strict_types=1);

namespace App\OpenApi\V1\User;

use App\OpenApi\V1\Paginator\PaginateResponse;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'NotificationPaginatedSchema',
    properties: [
        new OA\Property(
            property: 'data',
            ref: '#/components/schemas/NotificationResource',
            type: 'object'
        ),
    ],
    type: 'object'
)]
class NotificationPaginatedSchema extends PaginateResponse
{
}
