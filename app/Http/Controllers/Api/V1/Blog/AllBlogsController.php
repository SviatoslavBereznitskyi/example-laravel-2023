<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Blog;

use App\Http\Resources\Blog\BlogResource;
use App\Models\Blog\Enums\BlogSortEnum;
use App\Repositories\Blog\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class AllBlogsController
{
    public function __construct(private BlogRepository $repository)
    {
    }

    #[OA\Get(
        path: 'blogs',
        operationId: 'AllBlogs',
        tags: ['Blog']
    )
    ]
    #[OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', description: 'Number of elements per page'))]
    #[OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', description: 'Number of elements per page'))]
    #[OA\Parameter(name: 'filter[category_id]', description: 'filter to select blogs via categories, ids coma separated', in: 'query', example: 'cd7ec92c-3533-4bf4-86eb-1ff4af03869e,cd7ec92c-3533-4bf4-86eb-1ff4af03869e')]
    #[OA\Parameter(name: 'filter[tag]', description: 'filter by tag', in: 'query', example: 'tag')]
    #[OA\Parameter(name: 'search', description: 'filter search blogs by title, description', in: 'query', example: 'word')]
    #[OA\Parameter(name: 'sort', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: [BlogSortEnum::SortLatest, BlogSortEnum::SortOldest]))]
    #[OA\Response(response: Response::HTTP_OK, description: 'Ok', content: new OA\JsonContent(ref: '#/components/schemas/BlogPaginationSchema'))]
    #[OA\Response(response: Response::HTTP_UNPROCESSABLE_ENTITY, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(Request $request): JsonResource
    {
        return BlogResource::collection($this->repository->with('images')->apiPaginate($request->per_page));
    }
}
