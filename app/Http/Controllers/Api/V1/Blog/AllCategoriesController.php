<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Blog;

use App\Http\Resources\Blog\BlogCategoryResource;
use App\Repositories\Blog\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class AllCategoriesController
{
    public function __construct(private CategoryRepository $repository)
    {
    }

    #[OA\Get(
        path: 'blogs/categories',
        operationId: 'AllBlogCategories',
        tags: ['Blog.Category']
    )]
    #[OA\Parameter(name: 'per_page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', description: 'Number of elements per page'))]
    #[OA\Parameter(name: 'page', in: 'query', required: false, schema: new OA\Schema(type: 'integer', description: 'Number of elements per page'))]
    #[OA\Response(response: Response::HTTP_OK, description: 'Ok', content: new OA\JsonContent(properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/BlogCategoryResource')
        ),
    ]))]
    public function __invoke(Request $request): JsonResource
    {
        return BlogCategoryResource::collection($this->repository->apiPaginate($request->per_page));
    }
}
