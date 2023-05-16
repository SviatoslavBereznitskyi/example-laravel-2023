<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Admin\Blog as BlogSections;
use App\Http\Admin\Catalog\Address\CityController;
use App\Http\Admin\Catalog\Address\MetroBranchController;
use App\Http\Admin\Catalog\Address\MetroController;
use App\Http\Admin\Catalog\Address\StreetController;
use App\Http\Admin\Catalog\Address\UndergroundBranchController;
use App\Http\Admin\Catalog\Agency\AgencyController;
use App\Http\Admin\Catalog\Apartment\ApartmentController;
use App\Http\Admin\Catalog\Apartment\StatisticController;
use App\Http\Admin\Catalog\Claim\ClaimController;
use App\Http\Admin\Catalog\Company\CompanyController;
use App\Http\Admin\Catalog\Complex\BlocTabController;
use App\Http\Admin\Catalog\Complex\ComplexController;
use App\Http\Admin\Catalog\Complex\ComplexDetailController;
use App\Http\Admin\Catalog\Complex\ComplexDocumentBlocController;
use App\Http\Admin\Catalog\Complex\ComplexFloorTypeController;
use App\Http\Admin\Catalog\Complex\ComplexImageGroupController;
use App\Http\Admin\Catalog\Complex\ComplexLookController;
use App\Http\Admin\Catalog\Complex\ComplexPlanController;
use App\Http\Admin\Catalog\Complex\ComplexVisitController;
use App\Http\Admin\Catalog\Complex\InfrastructureController;
use App\Http\Admin\Catalog\Dictionary\AdditionalController;
use App\Http\Admin\Catalog\Dictionary\BathroomController;
use App\Http\Admin\Catalog\Dictionary\ClaimApartmentController;
use App\Http\Admin\Catalog\Dictionary\ClaimMessageController;
use App\Http\Admin\Catalog\Dictionary\ClassController;
use App\Http\Admin\Catalog\Dictionary\ComfortController;
use App\Http\Admin\Catalog\Dictionary\CommunicationController;
use App\Http\Admin\Catalog\Dictionary\ComplexTechnologyController;
use App\Http\Admin\Catalog\Dictionary\ComplexVisitReasonController;
use App\Http\Admin\Catalog\Dictionary\FlooringController;
use App\Http\Admin\Catalog\Dictionary\HeatingController;
use App\Http\Admin\Catalog\Dictionary\InfrastructureCategoryController;
use App\Http\Admin\Catalog\Dictionary\InsulationController;
use App\Http\Admin\Catalog\Dictionary\LandBuildingController;
use App\Http\Admin\Catalog\Dictionary\LandscapeController;
use App\Http\Admin\Catalog\Dictionary\MachineController;
use App\Http\Admin\Catalog\Dictionary\MultimediaController;
use App\Http\Admin\Catalog\Dictionary\OverlapController;
use App\Http\Admin\Catalog\Dictionary\ParkingController;
use App\Http\Admin\Catalog\Dictionary\PlanTypeController;
use App\Http\Admin\Catalog\Dictionary\PropertyController;
use App\Http\Admin\Catalog\Dictionary\RepairController;
use App\Http\Admin\Catalog\Dictionary\RoofController;
use App\Http\Admin\Catalog\Dictionary\SecurityController;
use App\Http\Admin\Catalog\Dictionary\SelectController;
use App\Http\Admin\Catalog\Dictionary\SetController;
use App\Http\Admin\Catalog\Dictionary\StatusController;
use App\Http\Admin\Catalog\Dictionary\SubcategoryController;
use App\Http\Admin\Catalog\Dictionary\ToggleController;
use App\Http\Admin\Catalog\Dictionary\WallController;
use App\Http\Admin\Charity\CharityController;
use App\Http\Admin\Charity\VideoController;
use App\Http\Admin\Common\AchievementController;
use App\Http\Admin\Common\ActualizationPriceController;
use App\Http\Admin\Common\ContactController;
use App\Http\Admin\Common\DailyController;
use App\Http\Admin\Common\ExchangeLimitController;
use App\Http\Admin\Common\ExchangeRateController;
use App\Http\Admin\Common\FaqController;
use App\Http\Admin\Common\RaisePriceController;
use App\Http\Admin\Common\SettingsController;
use App\Http\Admin\Notary\NotaryController;
use App\Http\Admin\Page\MainpageController;
use App\Http\Admin\Page\PageController;
use App\Http\Admin\Promo\PromoCodeController;
use App\Http\Admin\Raffle\CategoryController;
use App\Http\Admin\Raffle\RaffleController;
use App\Http\Admin\Task\TaskController;
use App\Http\Admin\User\FeedbackMessageController;
use App\Http\Admin\User\OtpCodeController;
use App\Http\Admin\User\RBAC\PermissionController;
use App\Http\Admin\User\RBAC\RoleController;
use App\Http\Admin\User\UserController;
use App\Models\Blog;
use App\Models\Catalog\ActualizationPrice;
use App\Models\Catalog\Agency\Agency;
use App\Models\Catalog\Apartment;
use App\Models\Catalog\ApartmentAdditional;
use App\Models\Catalog\ApartmentBathroom;
use App\Models\Catalog\ApartmentClass;
use App\Models\Catalog\ApartmentComfort;
use App\Models\Catalog\ApartmentFlooring;
use App\Models\Catalog\ApartmentHeating;
use App\Models\Catalog\ApartmentInsulation;
use App\Models\Catalog\ApartmentLandscape;
use App\Models\Catalog\ApartmentMachine;
use App\Models\Catalog\ApartmentMultimedia;
use App\Models\Catalog\ApartmentOverlap;
use App\Models\Catalog\ApartmentParking;
use App\Models\Catalog\ApartmentRepair;
use App\Models\Catalog\ApartmentRoof;
use App\Models\Catalog\ApartmentSecuritytype;
use App\Models\Catalog\ApartmentStatistic;
use App\Models\Catalog\ApartmentStatus;
use App\Models\Catalog\ApartmentSubcategory;
use App\Models\Catalog\ApartmentWall;
use App\Models\Catalog\City;
use App\Models\Catalog\ClaimApartment;
use App\Models\Catalog\ClaimApartmentUser;
use App\Models\Catalog\Communication;
use App\Models\Catalog\Company\Company;
use App\Models\Catalog\Company\ResidentialComplex\ComplexDetail;
use App\Models\Catalog\Company\ResidentialComplex\ComplexTechnology\ComplexTechnology;
use App\Models\Catalog\Company\ResidentialComplex\Infrastructure\InfrastrucCategory;
use App\Models\Catalog\Company\ResidentialComplex\Infrastructure\Infrastructure;
use App\Models\Catalog\Company\ResidentialComplex\Profitability\ComplexFloortype;
use App\Models\Catalog\Company\ResidentialComplex\Profitability\ComplexLook;
use App\Models\Catalog\Company\ResidentialComplex\ResidentialComplex;
use App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexDocument\ComplexDocumentBloc;
use App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexDocument\DocumentBlocTab;
use App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexImage\ComplexImageGroup;
use App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexImage\ComplexPlanImage;
use App\Models\Catalog\Company\ResidentialComplex\ResidentialComplexImage\PlanType;
use App\Models\Catalog\Company\ResidentialComplex\Visit\ComplexVisit;
use App\Models\Catalog\Company\ResidentialComplex\Visit\ComplexVisitReason;
use App\Models\Catalog\LandBuilding;
use App\Models\Catalog\Metro;
use App\Models\Catalog\MetroBranch;
use App\Models\Catalog\Property;
use App\Models\Catalog\RaisePrice;
use App\Models\Catalog\Select;
use App\Models\Catalog\Set;
use App\Models\Catalog\Street;
use App\Models\Catalog\Toggle;
use App\Models\Catalog\UndergroundBranch;
use App\Models\Charity;
use App\Models\Notary\Notary;
use App\Models\Page\MainpageBlock;
use App\Models\Page\Page;
use App\Models\Promo\PromoCode;
use App\Models\Raffle\Category;
use App\Models\Raffle\Raffle;
use App\Models\Settings\Contact;
use App\Models\Settings\ExchangeLimit;
use App\Models\Settings\ExchangeRate;
use App\Models\Settings\Faq;
use App\Models\Settings\Setting;
use App\Models\Tasks\Task;
use App\Models\User\Achievement;
use App\Models\User\ClaimMessage;
use App\Models\User\ClaimMessageUser;
use App\Models\User\Daily;
use App\Models\User\FeedbackMessage;
use App\Models\User\OtpCode;
use App\Models\User\RBAC\Permission;
use App\Models\User\RBAC\Role;
use App\Models\User\User;
use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $sections = [
        Category::class => CategoryController::class,
        Raffle::class => RaffleController::class,
        Task::class => TaskController::class,
        Charity\Charity::class => CharityController::class,
        Charity\Video::class => VideoController::class,
        Setting::class => SettingsController::class,
        Page::class => PageController::class,
        MainpageBlock::class => MainpageController::class,
        FeedbackMessage::class => FeedbackMessageController::class,
        Blog\Blog::class => BlogSections\BlogController::class,
        Blog\Category::class => BlogSections\CategoryController::class,
        Contact::class => ContactController::class,
        PromoCode::class => PromoCodeController::class,
        ExchangeLimit::class => ExchangeLimitController::class,
        User::class => UserController::class,
        OtpCode::class => OtpCodeController::class,
        ExchangeRate::class => ExchangeRateController::class,
        Faq::class => FaqController::class,

        // Claim
        ClaimApartmentUser::class => ClaimController::class,
        ClaimMessageUser::class => \App\Http\Admin\User\Claim\ClaimMessageController::class,

        // Dictionary
        ApartmentFlooring::class => FlooringController::class,
        ApartmentHeating::class => HeatingController::class,
        ApartmentOverlap::class => OverlapController::class,
        ApartmentParking::class => ParkingController::class,
        ApartmentRepair::class => RepairController::class,
        ApartmentSecuritytype::class => SecurityController::class,
        ApartmentWall::class => WallController::class,
        ApartmentStatus::class => StatusController::class,
        ApartmentClass::class => ClassController::class,
        Toggle::class => ToggleController::class,
        Property::class => PropertyController::class,
        ApartmentSubcategory::class => SubcategoryController::class,
        ClaimApartment::class => ClaimApartmentController::class,
        ClaimMessage::class => ClaimMessageController::class,
        ApartmentInsulation::class => InsulationController::class,
        ApartmentRoof::class => RoofController::class,
        ApartmentBathroom::class => BathroomController::class,
        ApartmentMachine::class => MachineController::class,
        ApartmentComfort::class => ComfortController::class,
        ApartmentMultimedia::class => MultimediaController::class,
        ApartmentLandscape::class => LandscapeController::class,
        ApartmentAdditional::class => AdditionalController::class,
        Communication::class => CommunicationController::class,
        LandBuilding::class => LandBuildingController::class,
        Set::class => SetController::class,
        Select::class => SelectController::class,
        PlanType::class => PlanTypeController::class,
        InfrastrucCategory::class => InfrastructureCategoryController::class,
        ComplexVisitReason::class => ComplexVisitReasonController::class,
        ComplexLook::class => ComplexLookController::class,
        ComplexFloortype::class => ComplexFloorTypeController::class,

        // Catalog
        Apartment::class => ApartmentController::class,
        ResidentialComplex::class => ComplexController::class,
        ComplexImageGroup::class => ComplexImageGroupController::class,
        ComplexDocumentBloc::class => ComplexDocumentBlocController::class,
        DocumentBlocTab::class => BlocTabController::class,
        ComplexPlanImage::class => ComplexPlanController::class,
        Infrastructure::class => InfrastructureController::class,
        ComplexTechnology::class => ComplexTechnologyController::class,
        Company::class => CompanyController::class,
        Agency::class => AgencyController::class,
        ApartmentStatistic::class => StatisticController::class,
        ComplexVisit::class => ComplexVisitController::class,
        ComplexDetail::class => ComplexDetailController::class,
        Metro::class => MetroController::class,
        MetroBranch::class => MetroBranchController::class,
        Street::class => StreetController::class,
        City::class => CityController::class,

        // RBAC
        Permission::class => PermissionController::class,
        Role::class => RoleController::class,

        Daily::class => DailyController::class,
        UndergroundBranch::class => UndergroundBranchController::class,
        Achievement::class => AchievementController::class,
        Notary::class => NotaryController::class,
        ActualizationPrice::class => ActualizationPriceController::class,
        RaisePrice::class => RaisePriceController::class,
    ];

    /**
     * Register sections.
     */
    public function boot(\SleepingOwl\Admin\Admin $admin): void
    {
        parent::boot($admin);
    }
}
