<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Blog;

use App\Http\Resources\Blog\BlogResource;
use App\Repositories\Blog\BlogRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class GetBlogController
{
    public function __construct(private BlogRepository $repository)
    {
    }

    #[OA\Get(path: 'blogs/{slug}', operationId: 'GetBlog', tags: ['Blog'])]
    #[OA\Parameter(name: 'slug', description: 'blog slug', in: 'path', example: 'slug')]
    #[OA\Response(response: Response::HTTP_OK, description: 'Ok', content: new OA\JsonContent(properties: [
        new OA\Property(
            property: 'data',
            ref: '#/components/schemas/BlogResource',
            type: 'object',
        ),
    ]))]
    #[OA\Response(response: Response::HTTP_NOT_FOUND, description: 'Not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse'))]
    public function __invoke(string $slug): JsonResource
    {
        return BlogResource::make($this->repository->with(['images', 'category'])->getBySlug($slug));
    }
}
