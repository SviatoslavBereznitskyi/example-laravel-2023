<?php

declare(strict_types=1);

use App\Models\Blog\Blog;
use App\Models\Blog\Category;
use App\Models\Catalog\City;
use App\Models\Catalog\Company\ResidentialComplex\ComplexDetail;
use App\Models\Catalog\Company\ResidentialComplex\Visit\ComplexVisit;
use App\Models\Catalog\Metro;
use App\Models\Catalog\MetroBranch;
use App\Models\Catalog\Street;
use App\Models\Charity\Charity;
use App\Models\Charity\Video;
use App\Models\Raffle\Raffle;
use App\Models\Settings\ExchangeLimit;
use App\Models\Settings\ExchangeRate;
use App\Models\Settings\Faq;
use App\Models\Settings\Setting;
use App\Models\User\Daily;
use App\Models\User\RBAC\Permission;
use App\Models\User\RBAC\Role;
use SleepingOwl\Admin\Navigation\Page;

// Default check access logic
// AdminNavigation::setAccessLogic(function(Page $page) {
// 	   return auth()->user()->isSuperAdmin();
// });
//
// AdminNavigation::addPage(\App\User::class)->setTitle('test')->setPages(function(Page $page) {
// 	  $page
//		  ->addPage()
//	  	  ->setTitle('Dashboard')
//		  ->setUrl(route('admin.dashboard'))
//		  ->setPriority(100);
//
//	  $page->addPage(\App\User::class);
// });
//
// // or
//
// AdminSection::addMenuPage(\App\User::class)

return [
    //    [
    //        'title' => 'Dashboard',
    //        'icon' => 'fas fa-tachometer-alt',
    //        'url' => route('admin.dashboard'),
    //    ],

    (new Page(App\Models\Catalog\Apartment::class))
        ->setPriority(0)
        ->setIcon('fas fa-check-double'),
    [
        'title' => 'Blog',
        'icon' => 'fas fa-rss',
        'priority' => 1200,
        'pages' => [
            (new Page(Blog::class))
                ->setPriority(1)
                ->setIcon('fas fa-rss'),
            (new Page(Category::class))
                ->setPriority(2)
                ->setIcon('fas fa-stream'),
        ],
    ],
    [
        'title' => 'Raffles',
        'icon' => 'fas fa-dice',
        'priority' => 1000,
        'pages' => [
            (new Page(Raffle::class))
                ->setPriority(1)
                ->setIcon('fas fa-dice'),
            (new Page(Charity::class))
                ->setPriority(2)
                ->setIcon('fas fa-heart'),
            (new Page(\App\Models\Raffle\Category::class))
                ->setPriority(2)
                ->setIcon('fas fa-stream'),
            (new Page(Video::class))
                ->setTitle('Charity video')
                ->setPriority(2)
                ->setIcon('fas fa-photo-video'),
        ],
    ],
    [
        'title' => 'Catalog',
        'icon' => 'fas fa-database',
        'priority' => 2000,
        'pages' => [
            (new Page(\App\Models\Catalog\Company\Company::class))
                ->setPriority(1)
                ->setIcon('fas fa-users'),
            (new Page(\App\Models\Catalog\Company\ResidentialComplex\ResidentialComplex::class))
                ->setPriority(2)
                ->setIcon('fas fa-city'),
            (new Page(\App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexImage\ComplexImageGroup::class))
                ->setPriority(3)
                ->setIcon('fas fa-images'),
            (new Page(\App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexDocument\ComplexDocumentBloc::class))
                ->setPriority(4)
                ->setIcon('fas fa-passport'),
            (new Page(\App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexDocument\DocumentBlocTab::class))
                ->setPriority(5)
                ->setIcon('fas fa-location-arrow'),
            (new Page(App\Models\Catalog\Company\ResidentialComplex\Infrastructure\Infrastructure::class))
                ->setPriority(6)
                ->setIcon('fas fa-location-arrow'),
            (new Page(\App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexImage\ComplexPlanImage::class))
                ->setPriority(5)
                ->setIcon('fas fa-ruler'),
            (new Page(\App\Models\Catalog\Company\ResidentialComplex\ComplexTechnology\ComplexTechnology::class))
                ->setPriority(7)
                ->setIcon('fas fa-industry'),
            (new Page(\App\Models\Catalog\Agency\Agency::class))
                ->setPriority(8)
                ->setIcon('fas fa-handshake'),
            (new Page(\App\Models\Catalog\ApartmentStatistic::class))
                ->setPriority(9)
                ->setIcon('fas fa-chart-line'),
            (new Page(ComplexVisit::class))
                ->setPriority(10)
                ->setIcon('fas fa-people-arrows'),
            (new Page(ComplexDetail::class))
                ->setPriority(11)
                ->setIcon('fas fa-info-circle'),
            (new Page(Metro::class))
                ->setPriority(12)
                ->setIcon('fas fa-subway'),
            (new Page(MetroBranch::class))
                ->setPriority(13)
                ->setIcon('fas fa-project-diagram'),
            (new Page(Street::class))
                ->setPriority(14)
                ->setIcon('fas fa-road'),
            (new Page(City::class))
                ->setPriority(15)
                ->setIcon('fas fa-city'),
        ],
    ],
    [
        'title' => 'Claim',
        'icon' => 'fa fa-exclamation-triangle',
        'priority' => 2500,
        'pages' => [
            (new Page(\App\Models\Catalog\ClaimApartmentUser::class))
                ->setPriority(5)
                ->setIcon('fas fa-exclamation-circle'),
            (new Page(\App\Models\User\ClaimMessageUser::class))
                ->setPriority(6)
                ->setIcon('fas fa-exclamation'),
        ],
    ],
    [
        'title' => 'Dictionary',
        'icon' => 'fas fa-book-open',
        'priority' => 3000,
        'pages' => [
            (new Page(\App\Models\Catalog\Toggle::class))
                ->setPriority(1)
                ->setIcon('fas fa-toggle-on'),
            (new Page(\App\Models\Catalog\Property::class))
                ->setPriority(2)
                ->setIcon('fas fa-keyboard'),
            (new Page(\App\Models\Catalog\Set::class))
                ->setPriority(3)
                ->setIcon('fas fa-ellipsis-h'),
            (new Page(\App\Models\Catalog\Select::class))
                ->setPriority(4)
                ->setIcon('fas fa-caret-square-down'),

            (new Page(\App\Models\Catalog\ApartmentFlooring::class))
                ->setPriority(4)
                ->setIcon('fas fa-table'),
            (new Page(\App\Models\Catalog\ApartmentHeating::class))
                ->setPriority(5)
                ->setIcon('fas fa-burn'),
            (new Page(\App\Models\Catalog\ApartmentOverlap::class))
                ->setPriority(6)
                ->setIcon('fas fa-chevron-up'),
            (new Page(\App\Models\Catalog\ApartmentParking::class))
                ->setPriority(7)
                ->setIcon('fas fa-parking'),
            (new Page(\App\Models\Catalog\ApartmentRepair::class))
                ->setPriority(8)
                ->setIcon('fas fa-hammer'),
            (new Page(\App\Models\Catalog\ApartmentSecuritytype::class))
                ->setPriority(9)
                ->setIcon('fas fa-shield-alt'),
            (new Page(\App\Models\Catalog\ApartmentWall::class))
                ->setPriority(10)
                ->setIcon('fas fa-th-large'),
            (new Page(\App\Models\Catalog\ApartmentStatus::class))
                ->setPriority(11)
                ->setIcon('fas fa-battery-half'),
            (new Page(\App\Models\Catalog\ApartmentClass::class))
                ->setPriority(12)
                ->setIcon('fas fa-hand-holding-usd'),

            (new Page(\App\Models\Catalog\ApartmentSubcategory::class))
                ->setPriority(13)
                ->setIcon('fas fa-list-ol'),
            (new Page(\App\Models\Catalog\ApartmentInsulation::class))
                ->setPriority(14)
                ->setIcon('fas fa-fire'),
            (new Page(\App\Models\Catalog\ApartmentRoof::class))
                ->setPriority(15)
                ->setIcon('fas fa-home'),
            (new Page(\App\Models\Catalog\ApartmentBathroom::class))
                ->setPriority(16)
                ->setIcon('fas fa-bath'),
            (new Page(\App\Models\Catalog\ApartmentMachine::class))
                ->setPriority(17)
                ->setIcon('fas fa-blender'),
            (new Page(\App\Models\Catalog\ApartmentComfort::class))
                ->setPriority(18)
                ->setIcon('fas fa-couch'),
            (new Page(\App\Models\Catalog\ApartmentMultimedia::class))
                ->setPriority(19)
                ->setIcon('fas fa-photo-video'),
            (new Page(\App\Models\Catalog\ApartmentLandscape::class))
                ->setPriority(20)
                ->setIcon('fas fa-umbrella-beach'),
            (new Page(\App\Models\Catalog\ApartmentAdditional::class))
                ->setPriority(21)
                ->setIcon('fas fa-plus'),
            (new Page(\App\Models\Catalog\Communication::class))
                ->setPriority(22)
                ->setIcon('fas fa-wifi'),
            (new Page(\App\Models\Catalog\LandBuilding::class))
                ->setPriority(23)
                ->setIcon('fas fa-landmark'),

            (new Page(\App\Models\Catalog\ClaimApartment::class))
                ->setPriority(30)
                ->setIcon('far fa-newspaper'),
            (new Page(\App\Models\User\ClaimMessage::class))
                ->setPriority(31)
                ->setIcon('fas fa-comment-slash'),
            (new Page(\App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexImage\PlanType::class))
                ->setPriority(32)
                ->setIcon('fas fa-vector-square'),

            (new Page(\App\Models\Catalog\Company\ResidentialComplex\Infrastructure\InfrastrucCategory::class))
                ->setPriority(33)
                ->setIcon('fas fa-coffee'),

            (new Page(\App\Models\Catalog\Company\ResidentialComplex\Visit\ComplexVisitReason::class))
                ->setPriority(34)
                ->setIcon('fas fa-running'),
            (new Page(\App\Models\Catalog\Company\ResidentialComplex\Profitability\ComplexLook::class))
                ->setPriority(35)
                ->setIcon('fas fa-tree'),
            (new Page(\App\Models\Catalog\Company\ResidentialComplex\Profitability\ComplexFloortype::class))
                ->setPriority(36)
                ->setIcon('fas fa-calculator'),
        ],
    ],
    [
        'title' => 'Settings',
        'icon' => 'fas fa-cogs',
        'priority' => 1000,
        'pages' => [
            (new Page(Setting::class))
                ->setPriority(1)
                ->setIcon('fas fa-cogs'),
            (new Page(ExchangeLimit::class))
                ->setPriority(2)
                ->setIcon('fas fa-heart'),
            (new Page(ExchangeRate::class))
                ->setPriority(2)
                ->setIcon('fas fa-stream'),
            (new Page(Role::class))
                ->setPriority(2)
                ->setIcon('fas fa-stream'),
            (new Page(Permission::class))
                ->setPriority(2)
                ->setIcon('fas fa-stream'),
            (new Page(Daily::class))
                ->setPriority(2)
                ->setIcon('fas fa-stream'),
            (new Page(Faq::class))
                ->setPriority(2)
                ->setIcon('fas fa-stream'),
            (new Page(\App\Models\Catalog\ActualizationPrice::class))
                ->setPriority(2)
                ->setIcon('fas fa-arrow-right'),
            (new Page(\App\Models\Catalog\RaisePrice::class))
                ->setPriority(2)
                ->setIcon('fas fa-arrow-up'),
        ],
    ],
    // Examples
    // [
    //    'title' => 'Content',
    //    'pages' => [
    //
    //        \App\User::class,
    //
    //        // or
    //
    //        (new Page(\App\User::class))
    //            ->setPriority(100)
    //            ->setIcon('fas fa-users')
    //            ->setUrl('users')
    //            ->setAccessLogic(function (Page $page) {
    //                return auth()->user()->isSuperAdmin();
    //            }),
    //
    //        // or
    //
    //        new Page([
    //            'title'    => 'News',
    //            'priority' => 200,
    //            'model'    => \App\News::class
    //        ]),
    //
    //        // or
    //        (new Page(/* ... */))->setPages(function (Page $page) {
    //            $page->addPage([
    //                'title'    => 'Blog',
    //                'priority' => 100,
    //                'model'    => \App\Blog::class
    //		      ));
    //
    //		      $page->addPage(\App\Blog::class);
    //	      }),
    //
    //        // or
    //
    //        [
    //            'title'       => 'News',
    //            'priority'    => 300,
    //            'accessLogic' => function ($page) {
    //                return $page->isActive();
    //		      },
    //            'pages'       => [
    //
    //                // ...
    //
    //            ]
    //        ]
    //    ]
    // ]
];
