<?php

declare(strict_types=1);

namespace App\Models\Blog;

use App\Models\Page\SeoParameter;
use App\Traits\AutoGeneraleUuid;
use App\Traits\QueryBuilderTrait;
use App\Traits\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * App\Models\Blog\Blog.
 *
 * @property string $id
 * @property string $slug
 * @property string|null $seo_parameter_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \App\Models\Blog\Category|null $category
 * @property \App\Models\Blog\Image[]|\Illuminate\Database\Eloquent\Collection $images
 * @property int|null $images_count
 * @property \App\Models\Blog\BlogTranslation|null $translation
 * @property \App\Models\Blog\BlogTranslation[]|\Illuminate\Database\Eloquent\Collection $translations
 * @property int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Blog listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog makeBuilder()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Blog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereSeoParameterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Blog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Blog withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $category_id
 * @property SeoParameter|null $seoParameter
 * @method static Builder|Blog categories(string $value)
 * @method static Builder|Blog whereCategoryId($value)
 * @property array|null $tags
 * @method static Builder|Blog whereTags($value)
 * @property array|null $tags_admin
 * @method static Builder|Blog search($value)
 * @method static Builder|Blog tag($value)
 */
class Blog extends Model implements TranslatableContract
{
    use AutoGeneraleUuid;
    use HasFactory;
    use QueryBuilderTrait;
    use SoftDeletes;
    use Translatable;

    public $translatedAttributes = [
        'title',
        'description',
        'content',
    ];

    protected $keyType = 'string';

    protected $with = ['seoParameter'];

    protected $fillable = [
        'id',
        'slug',
        'seo_parameter_id',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('category_id'),
            AllowedFilter::scope('search'),
            AllowedFilter::scope('tag'),
        ];
    }

    public function scopeSearch(Builder $builder, $value): Builder
    {
        return $builder->whereHas('translation', static function ($q) use ($value): void {
            $q
                ->whereRaw("title ~* '" . $value . "'")
                ->orWhereRaw("description ~*'" . $value . "'");
        });
    }

    public function getAllowedSorts(): array
    {
        return [
            AllowedSort::callback('latest', static function ($query): void {
                $query->latest('updated_at');
            }),
            AllowedSort::callback('oldest', static function ($query): void {
                $query->oldest('updated_at');
            }),
        ];
    }

    public function scopeTag(Builder $builder, $value): Builder
    {
        return $builder->where('tags', 'like', '%' . $value . '%');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function seoParameter(): BelongsTo
    {
        return $this->belongsTo(SeoParameter::class);
    }

    public function getTagsAdminAttribute(): ?string
    {
        return $this->tags ? implode(',', $this->tags) : null;
    }

    public function setTagsAdminAttribute($value): void
    {
        $this->tags = $value ? explode(',', $value) : null;
    }

    public function translation(): HasOne
    {
        return $this->hasOne(BlogTranslation::class);
    }
}
