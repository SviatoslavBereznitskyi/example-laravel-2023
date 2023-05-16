<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Search\ElasticsearchInterface;
use App\Services\Search\ElasticsearchRepository;
use Elastic\Elasticsearch\Client;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class ModelServiceProvider.
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ElasticsearchInterface::class,
            static fn ($app) => new ElasticsearchRepository($app->make(Client::class))
        );
    }
}
