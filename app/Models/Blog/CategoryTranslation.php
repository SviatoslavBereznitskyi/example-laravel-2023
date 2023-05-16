<?php

declare(strict_types=1);

namespace App\Models\Blog;

use App\Traits\AutoGeneraleUuid;
use App\Traits\QueryBuilderTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Blog\CategoryTranslation.
 *
 * @property string $id
 * @property string $blog_category_id
 * @property string $locale
 * @property string $title
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation makeBuilder()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereBlogCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereTitle($value)
 * @mixin \Eloquent
 * @property string $category_id
 * @method static \Illuminate\Database\Eloquent\Builder|CategoryTranslation whereCategoryId($value)
 */
class CategoryTranslation extends Model
{
    use AutoGeneraleUuid;
    use HasFactory;
    use QueryBuilderTrait;

    public $timestamps = false;

    protected $keyType = 'string';

    protected $table = 'blog_category_translations';

    protected $fillable = [
        'id',
        'blog_category_id',
        'locale',
        'title',
    ];
}
