<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\NotificationManager;
use App\Contracts\RaffleService;
use App\Contracts\SettingManager;
use App\Repositories\Settings\SettingRepository;
use App\Services\Bank\ExchangeRateService;
use App\Services\Bank\ExchangeRateServiceNationalBank;
use App\Services\CentrifugoNotificationService;
use App\Services\Raffle\BlockchainRaffleService;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.use_https')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        $this->app->bind(SettingManager::class, SettingRepository::class);
        $this->app->bind(RaffleService::class, BlockchainRaffleService::class);
        $this->app->bind(NotificationManager::class, CentrifugoNotificationService::class);
        $this->app->bind(ExchangeRateService::class, ExchangeRateServiceNationalBank::class);

        $this->app->bind(Client::class, static function () {
            $hosts = config('services.search.hosts');
            $clientBuilder = ClientBuilder::create()->setHosts($hosts);
            return $clientBuilder->build();
        });
    }
}
