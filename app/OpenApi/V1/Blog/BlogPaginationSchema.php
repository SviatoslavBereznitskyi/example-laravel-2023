<?php

declare(strict_types=1);

namespace App\OpenApi\V1\Blog;

use App\OpenApi\V1\Paginator\PaginateResponse;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'BlogPaginationSchema',
    properties: [
        new OA\Property(
            property: 'data',
            ref: '#/components/schemas/BlogResource',
            type: 'object'
        ),
    ],
    type: 'object'
)]
class BlogPaginationSchema extends PaginateResponse
{
}
