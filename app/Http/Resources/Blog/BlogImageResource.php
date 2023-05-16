<?php

declare(strict_types=1);

namespace App\Http\Resources\Blog;

use App\Models\Blog\Image;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: self::class,
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'path', type: 'string', format: 'uri'),
    ]
)]
final class BlogImageResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Image $this */
        return [
            'id' => $this->id,
            'path' => $this->uri,
        ];
    }
}
