<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Blog\Blog;
use App\Models\Blog\Category;
use App\Models\Catalog\Apartment;
use App\Models\Catalog\City;
use App\Models\Catalog\Company\ResidentialComplex\Infrastructure\Infrastructure;
use App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexImage\ComplexPlanImage;
use App\Models\Raffle\Raffle;
use App\Models\User\Message;
use App\Models\User\MessageImage;
use App\Models\User\SocialUser;
use App\Models\User\Transaction;
use App\Models\User\User;
use App\Observers\ApartmentObserver;
use App\Observers\BlogCategoryObserver;
use App\Observers\BlogObserver;
use App\Observers\CityObserver;
use App\Observers\ComplexPlanImageObserver;
use App\Observers\InfrastructureObserver;
use App\Observers\MessageFileObserver;
use App\Observers\MessageObserver;
use App\Observers\RaffleObserver;
use App\Observers\SocialUserObserver;
use App\Observers\TransactionObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Blog::observe(BlogObserver::class);
        Raffle::observe(RaffleObserver::class);
        Transaction::observe(TransactionObserver::class);
        Apartment::observe(ApartmentObserver::class);
        Message::observe(MessageObserver::class);
        MessageImage::observe(MessageFileObserver::class);
        Category::observe(BlogCategoryObserver::class);
        SocialUser::observe(SocialUserObserver::class);
        ComplexPlanImage::observe(ComplexPlanImageObserver::class);
        Infrastructure::observe(InfrastructureObserver::class);
        City::observe(CityObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
