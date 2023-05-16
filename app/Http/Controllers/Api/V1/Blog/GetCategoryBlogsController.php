<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Blog;

use App\Criteria\CategorySlugCriteria;
use App\Http\Resources\Blog\BlogResource;
use App\Models\Blog\Enums\DefaultCategoriesEnum;
use App\Repositories\Blog\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class GetCategoryBlogsController
{
    public function __construct(private BlogRepository $repository)
    {
    }

    #[OA\Get(path: 'blogs/categories/{slug}', operationId: 'GetCategoryBlogs', tags: ['Blog.Category'])]
    #[OA\Parameter(name: 'slug', description: 'blog category slug', in: 'path', example: DefaultCategoriesEnum::Charity)]
    #[OA\Response(response: Response::HTTP_OK, description: 'Ok', content: new OA\JsonContent(ref: '#/components/schemas/BlogPaginationSchema'))]
    #[OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(string $slug, Request $request): JsonResource
    {
        $this->repository->pushCriteria(new CategorySlugCriteria($slug));

        return BlogResource::collection($this->repository->with('images')->apiPaginate($request->per_page));
    }
}
