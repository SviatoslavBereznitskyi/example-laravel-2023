<?php

declare(strict_types=1);

namespace App\Models\Blog;

use App\Traits\AutoGeneraleUuid;
use App\Traits\QueryBuilderTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Blog\BlogTranslation.
 *
 * @property string $id
 * @property string $blog_id
 * @property string $locale
 * @property string $title
 * @property string $description
 * @property string $content
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation makeBuilder()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereBlogId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class BlogTranslation extends Model
{
    use AutoGeneraleUuid;
    use HasFactory;
    use QueryBuilderTrait;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'blog_id',
        'locale',
        'title',
        'description',
        'content',
    ];
}
