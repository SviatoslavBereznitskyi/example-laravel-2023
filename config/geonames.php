<?php

declare(strict_types=1);

use App\Models\Catalog\City;
use App\Models\Catalog\Continent;
use App\Models\Catalog\Country;
use App\Models\Catalog\Division;
use App\Services\Geonames\Suppliers\CitySupplier;
use App\Services\Geonames\Suppliers\ContinentSupplier;
use App\Services\Geonames\Suppliers\CountrySupplier;
use App\Services\Geonames\Suppliers\DivisionSupplier;
use App\Services\Geonames\Suppliers\TranslationSupplier;
use Nevadskiy\Geonames\Suppliers;

use function App\env;

return [
    /*
    |--------------------------------------------------------------------------
    | Geonames resources directory
    |--------------------------------------------------------------------------
    |
    | A directory for geonames meta files and downloads.
    |
    */

    'username' => env('GEONAMES_USERNAME'),

    'directory' => storage_path('meta/geonames'),

    /*
    |--------------------------------------------------------------------------
    | Geonames source
    |--------------------------------------------------------------------------
    |
    | You can choose appropriate data source for seeding as one of
    | SOURCE_ALL_COUNTRIES, SOURCE_SINGLE_COUNTRY or SOURCE_ONLY_CITIES.
    |
    | - SOURCE_ALL_COUNTRIES has the biggest database size but contains the most items.
    |
    | - SOURCE_SINGLE_COUNTRY contains only items that belongs to the specific country.
    | You can specify which country (or countries) you are going to seed in filters array by ISO code (e.g. US, GB).
    |
    | - SOURCE_ONLY_CITIES has the smallest size and contains only cities.
    | Other tables (continents, countries, divisions) will not be seeded.
    |
    | More info: http://download.geonames.org/export/dump/
    |
    */

    'source' => Nevadskiy\Geonames\Services\DownloadService::SOURCE_ALL_COUNTRIES,

    /*
    |--------------------------------------------------------------------------
    | Seed filters
    |--------------------------------------------------------------------------
    |
    | Specify filters for geonames data seeding.
    |
    */

    'filters' => [
        'countries' => ['ua', 'pl', 'tr', 'ae', 'kz', 'es'],

        'population' => 50000,
    ],

    /*
    |--------------------------------------------------------------------------
    | Geonames models
    |--------------------------------------------------------------------------
    |
    | Specify models that will be used in the application.
    | If you do not need any of them, set a model as 'false'.
    |
    */

    'models' => [
        'continent' => Continent::class,

        'country' => Country::class,

        'division' => Division::class,

        'city' => City::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default package boot settings
    |--------------------------------------------------------------------------
    |
    | Configure default package settings like loading default migrations,
    | morph mapping for models and others according to personal needs.
    |
    */

    'default_migrations' => false,

    'default_morph_map' => true,

    /*
    |--------------------------------------------------------------------------
    | Translations
    |--------------------------------------------------------------------------
    |
    | Set up translations configurations.
    | You can disable translations or specify your own languages list for translations.
    |
    */

    // Indicates if the translations should be supplied.
    'translations' => true,

    // Indicates the language list for translations.
    'languages' => ['en', 'pl', 'ru', 'uk', 'es', 'tr'],

    /*
     * Indicates if nullable languages should be supplied.
     * Some geonames alternate names have no defined concrete language.
     * Its can be useful for searching, but it increases the database size.
     */
    'nullable_language' => false,

    /*
    |--------------------------------------------------------------------------
    | Default geonames suppliers
    |--------------------------------------------------------------------------
    |
    | Override it when you are going to use custom migrations
    | with own custom insert, update and delete logic.
    |
    */

    'suppliers' => [
        Suppliers\ContinentSupplier::class => ContinentSupplier::class,
        Suppliers\CountrySupplier::class => CountrySupplier::class,
        Suppliers\DivisionSupplier::class => DivisionSupplier::class,
        Suppliers\CitySupplier::class => CitySupplier::class,
        Suppliers\Translations\TranslationSupplier::class => TranslationSupplier::class,
    ],
];
