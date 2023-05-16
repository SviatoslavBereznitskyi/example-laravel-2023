<?php

declare(strict_types=1);

namespace App\Http\Resources\Blog;

use App\Http\Resources\Seo\SeoParameterResource;
use App\Models\Blog\Category;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'BlogCategoryResource',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'slug', type: 'string'),
        new OA\Property(property: 'title', type: 'string'),
        new OA\Property(
            property: 'seo_parameters',
            ref: '#/components/schemas/SeoParameterResource',
            type: 'string'
        ),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
    ],
    type: 'object'
)]
class BlogCategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Category $this */
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'seo_parameters' => SeoParameterResource::make($this->seoParameter),
            'createdAt' => $this->created_at,
        ];
    }
}
