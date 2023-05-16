<?php

declare(strict_types=1);

namespace App\Http\Resources\Blog;

use App\Http\Resources\Seo\SeoParameterResource;
use App\Models\Blog\Blog;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'BlogResource',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'category_id', type: 'string', format: 'uuid'),
        new OA\Property(
            property: 'category',
            ref: '#/components/schemas/BlogCategoryResource',
            type: 'object'
        ),
        new OA\Property(property: 'slug', type: 'string'),
        new OA\Property(property: 'title', type: 'string'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'content', type: 'string'),
        new OA\Property(
            property: 'seo_parameters',
            ref: '#/components/schemas/SeoParameterResource',
            type: 'object'
        ),
        new OA\Property(
            property: 'images',
            ref: '#/components/schemas/' . BlogImageResource::class,
            type: 'object'
        ),
        new OA\Property(
            property: 'tags',
            type: 'array',
            items: new OA\Items(
                type: 'string',
            ),
            nullable: true
        ),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
    ],
    type: 'object'
)]
class BlogResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Blog $this */
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => BlogCategoryResource::make($this->whenLoaded('category')),
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'seo_parameters' => SeoParameterResource::make($this->seoParameter),
            'createdAt' => $this->created_at->format('d.m.Y'),
            'images' => BlogImageResource::collection($this->whenLoaded('images')),
            'tags' => $this->tags,
        ];
    }
}
