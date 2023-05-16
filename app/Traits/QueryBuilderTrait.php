<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

trait QueryBuilderTrait
{
    private array $queryBuilderTraitAllowedFilters = [];

    private array $queryBuilderTraitAllowedFields = [];

    private array $queryBuilderTraitAllowedAppends = [];

    private array $queryBuilderTraitAllowedRelations = [];

    private array $queryBuilderTraitAllowedSorts = [];

    public static function scopeMakeBuilder(Builder $eloquent): QueryBuilder
    {
        $builder = QueryBuilder::for($eloquent);
        $object = (new self());
        $search = request()->query('search');
        if (!empty($search) && $builder->hasNamedScope('search')) {
            $builder->search($search);
        }
        if ($object->queryBuilderTraitAllowedFields) {
            $builder->allowedFields($object->queryBuilderTraitAllowedFields);
        }
        if ($object->queryBuilderTraitAllowedAppends) {
            $builder->allowedAppends($object->queryBuilderTraitAllowedAppends);
        }
        if ($object->queryBuilderTraitAllowedFilters) {
            $builder->allowedFilters($object->queryBuilderTraitAllowedFilters);
        }
        if ($object->queryBuilderTraitAllowedSorts) {
            $builder->allowedSorts($object->queryBuilderTraitAllowedSorts);
        }
        if ($object->queryBuilderTraitAllowedRelations) {
            $builder->allowedIncludes($object->queryBuilderTraitAllowedRelations);
        }

        return $builder;
    }

    public function setDigitFilter($column): AllowedFilter
    {
        return AllowedFilter::callback($column, static fn (Builder $builder, $value) => $builder->betweenFilter($column, $value));
    }

    protected function initializeQueryBuilderTrait(): void
    {
        $availableFields = array_diff($this->getFillable(), $this->getHidden());
        $this->queryBuilderTraitAllowedFields = $this->allowedFields ?? $availableFields;
        $this->queryBuilderTraitAllowedAppends = $this->allowedAppends ?? [];
        if (method_exists($this, 'getAllowedFilters')) {
            $this->queryBuilderTraitAllowedFilters = $this->getAllowedFilters();
        } else {
            $this->queryBuilderTraitAllowedFilters = $this->allowedFilters ?? $availableFields;
        }

        if (method_exists($this, 'getAllowedSorts')) {
            $this->queryBuilderTraitAllowedSorts = $this->getAllowedSorts();
        } else {
            $this->queryBuilderTraitAllowedSorts = $this->allowedSorts ?? $availableFields;
        }
        $this->queryBuilderTraitAllowedRelations = $this->allowedRelations ?? [];
    }
}
