<?php

declare(strict_types=1);

namespace App\Traits;

use App\Observers\ElasticSearchObserver;

trait Searchable
{
    public static function bootSearchable(): void
    {
        static::observe(ElasticSearchObserver::class);
    }

    /**
     * @return string
     */
    public function getSearchIndex()
    {
        return $this->getTable();
    }

    /**
     * @return string
     */
    public function getSearchType()
    {
        return $this->getTable();
    }

    /**
     * @return array
     */
    public function toSearchArray()
    {
        return $this->toElasticsearchArray();
    }
}
