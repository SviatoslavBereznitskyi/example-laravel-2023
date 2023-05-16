<?php

declare(strict_types=1);

namespace App\Models\Blog;

use App\Models\Page\SeoParameter;
use App\Traits\AutoGeneraleUuid;
use App\Traits\QueryBuilderTrait;
use App\Traits\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Blog\Category.
 *
 * @property string $id
 * @property string $slug
 * @property string $title
 * @property string|null $seo_parameter_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \App\Models\Blog\Blog[]|\Illuminate\Database\Eloquent\Collection $blogs
 * @property int|null $blogs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category makeBuilder()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSeoParameterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Category withoutTrashed()
 * @mixin \Eloquent
 * @property \App\Models\Blog\CategoryTranslation|null $translation
 * @property \App\Models\Blog\CategoryTranslation[]|\Illuminate\Database\Eloquent\Collection $translations
 * @property int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Category notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Category translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Category translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Category withTranslation()
 * @property SeoParameter|null $seoParameter
 * @property bool $is_default
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereIsDefault($value)
 */
class Category extends Model implements TranslatableContract
{
    use AutoGeneraleUuid;
    use HasFactory;
    use QueryBuilderTrait;
    use SoftDeletes;
    use Translatable;

    public $translatedAttributes = [
        'title',
    ];

    protected $keyType = 'string';

    protected $table = 'blog_categories';

    protected $with = ['seoParameter'];

    protected $fillable = [
        'id',
        'slug',
        'seo_parameter_id',
        'is_default',
    ];

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function seoParameter(): BelongsTo
    {
        return $this->belongsTo(SeoParameter::class);
    }
}
