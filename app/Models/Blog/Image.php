<?php

declare(strict_types=1);

namespace App\Models\Blog;

use App\Traits\AutoGeneraleUuid;
use App\Traits\QueryBuilderTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Blog\Image.
 *
 * @property \App\Models\Blog\Blog $blog
 * @method static \Illuminate\Database\Eloquent\Builder|Image makeBuilder()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @mixin \Eloquent
 * @property string $id
 * @property string $uri
 * @property string $blog_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUri($value)
 */
class Image extends Model
{
    use AutoGeneraleUuid;
    use HasFactory;
    use QueryBuilderTrait;

    protected $table = 'blog_images';

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'uri',
        'blog_id',
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }
}
