<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Http\Resources\Catalog\Agency\AgencyResource;
use App\Http\Resources\Catalog\Company\CompanyResource;
use App\Models\Catalog\Enums\ApartmentUserTypeEnum;
use App\Models\User\Enums\AgencyManageTypeEnum;
use App\Models\User\Enums\ManageTypeEnum;
use App\Models\User\User;
use App\Repositories\Task\TaskRepository;
use App\Services\YoutubeService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UserResource',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'visibleId', type: 'integer'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'surname', type: 'string'),
        new OA\Property(property: 'sex', type: 'string'),
        new OA\Property(property: 'email', type: 'string', format: 'email'),
        new OA\Property(property: 'phone', type: 'string'),
        new OA\Property(property: 'additionalPhone', type: 'string'),
        new OA\Property(property: 'birthday', type: 'datetime'),
        new OA\Property(property: 'avatarUrl', type: 'string', format: 'uri'),
        new OA\Property(property: 'exchangeLimit', type: 'integer'),
        new OA\Property(property: 'exchangeLimitUsed', type: 'integer'),
        new OA\Property(property: 'completedTasks', type: 'integer'),
        new OA\Property(property: 'pointsFarmed', type: 'integer'),
        new OA\Property(property: 'tasksUncompleted', type: 'integer'),
        new OA\Property(property: 'emailConfirmed', type: 'boolean'),
        new OA\Property(property: 'phoneConfirmed', type: 'boolean'),
        new OA\Property(property: 'termsOfUseAccepted', type: 'boolean'),
        new OA\Property(property: 'isInstructed', type: 'boolean'),
        new OA\Property(property: 'visitedAt', type: 'string'),
        new OA\Property(property: 'visitedInRow', type: 'integer'),
        new OA\Property(property: 'rewardClaimed', type: 'boolean'),
        new OA\Property(property: 'createdAt', type: 'string', format: 'datetime'),
        new OA\Property(property: 'role', type: 'string', enum: [User::ADMIN, User::MANAGER, User::USER]),
        new OA\Property(property: 'youtubeTokensExpiredAt', type: 'string', format: 'datetime', nullable: true),
        new OA\Property(property: 'unpaidOrders', type: 'integer', nullable: true),
        new OA\Property(property: 'balance', ref: '#/components/schemas/WalletResource', type: 'object'),
        new OA\Property(property: 'socials', type: 'array', items: new OA\Items(
            ref: '#/components/schemas/SocialUserResource'
        )),
        new OA\Property(property: 'permissions', type: 'array', items: new OA\Items(
            type: 'string',
        )),
        new OA\Property(property: 'draftApartmentCount', type: 'integer'),
        new OA\Property(property: 'pendingApartmentCount', type: 'integer'),
        new OA\Property(property: 'publishedApartmentCount', type: 'integer'),
        new OA\Property(property: 'moderationApartmentCount', type: 'integer'),
        new OA\Property(property: 'rejectedApartmentCount', type: 'integer'),
        new OA\Property(property: 'archivedApartmentCount', type: 'integer'),
        new OA\Property(property: 'developerApartmentCount', type: 'integer'),

        new OA\Property(property: 'favoriteApartmentCount', type: 'integer'),
        new OA\Property(property: 'favoriteDeveloperApartmentCount', type: 'integer'),
        new OA\Property(property: 'favoriteAgencyApartmentCount', type: 'integer'),
        new OA\Property(property: 'favoriteComplexCount', type: 'integer'),

        new OA\Property(property: 'inApartmentDialogueCount', type: 'integer'),
        new OA\Property(property: 'outApartmentDialogueCount', type: 'integer'),
        new OA\Property(property: 'markerApartmentDialogueCount', type: 'integer'),
        new OA\Property(property: 'archiveApartmentDialogueCount', type: 'integer'),

        new OA\Property(property: 'unViewedInDialogueCount', type: 'integer'),
        new OA\Property(property: 'unViewedOutDialogueCount', type: 'integer'),
        new OA\Property(property: 'unViewedMarkerDialogueCount', type: 'integer'),
        new OA\Property(property: 'unViewedArchiveDialogueCount', type: 'integer'),

        new OA\Property(property: 'achievementCount', type: 'integer'),

        new OA\Property(property: 'company', ref: '#/components/schemas/' . CompanyResource::class, type: 'object'),
        new OA\Property(property: 'companyManageType', type: 'string', enum: [ManageTypeEnum::MANAGER, ManageTypeEnum::DIRECTOR]),
        new OA\Property(property: 'companyManageTypeTranslate', type: 'string'),

        new OA\Property(property: 'agency', ref: '#/components/schemas/' . AgencyResource::class, type: 'object'),
        new OA\Property(property: 'agencyManageType', type: 'string', enum: [AgencyManageTypeEnum::HEAD, AgencyManageTypeEnum::REALTOR]),
        new OA\Property(property: 'agencyManageTypeTranslate', type: 'string'),

        new OA\Property(property: 'privateType', type: 'string', enum: [ApartmentUserTypeEnum::PrivateRealtor, ApartmentUserTypeEnum::PrivatePerson]),
        new OA\Property(property: 'privateTypeTranslate', type: 'string'),
    ],
    type: 'object'
)]
class UserResource extends JsonResource
{
    private TaskRepository $taskRepository;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->taskRepository = resolve(TaskRepository::class);
    }

    public function toArray($request): array
    {
        /** @var User $this */
        $token = $this->socialTokens->where('provider', YoutubeService::YOUTUBE_PROVIDER)->sortBy('created_at', 0, true)->first()?->token;

        return [
            'id' => $this->id,
            'visibleId' => $this->visible_id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone' => $this->phone,
            'sex' => $this->sex,
            'birthday' => $this->birthday,
            'additionalPhone' => $this->additional_phone,
            'phoneConfirmed' => $this->phone_confirmed,
            'emailConfirmed' => $this->email_confirmed,
            'termsOfUseAccepted' => $this->terms_of_use_accepted,
            'avatarUrl' => $this->avatar_path,
            'exchangeLimit' => $this->exchange_limit,
            'exchangeLimitUsed' => $this->exchange_limit_used,
            'balance' => WalletResource::make($this->wallet),
            'socials' => SocialUserResource::collection($this->socialUsers),
            'role' => $this->role,
            'isInstructed' => $this->is_instructed,
            'youtubeTokensExpiredAt' => $token ? Carbon::parse($token['created'])->addSeconds($token['expires_in']) : null,
            'completedTasks' => $this->relationLoaded('completedTasks') ? $this->completedTasks->count() : 0,
            'pointsFarmed' => $this->relationLoaded('completedTasks') ? $this->completedTasks->pluck('task.price')->sum() : 0,
            'tasksUncompleted' => $this->relationLoaded('completedTasks') ? $this->taskRepository->count() - $this->completedTasks->count() : 0,
            'unpaidOrders' => $this->relationLoaded('orders') ? $this->orders->where('is_payed', false)->count() : null,
            'permissions' => $this->getPermissionsViaRoles()->pluck('name'),
            'rewardClaimed' => $this->reward_claimed,
            'visitedAt' => $this->visited_at,
            'visitedInRow' => $this->visited_in_row,
            'createdAt' => $this->created_at,

            'draftApartmentCount' => $this->DraftApartmentCount ?? 0,
            'pendingApartmentCount' => $this->PendingApartmentCount ?? 0,
            'publishedApartmentCount' => $this->PublishedApartmentCount ?? 0,
            'moderationApartmentCount' => $this->ModerationApartmentCount ?? 0,
            'rejectedApartmentCount' => $this->RejectedApartmentCount ?? 0,
            'archivedApartmentCount' => $this->ArchivedApartmentCount ?? 0,
            'developerApartmentCount' => $this->developerApartmentCount ?? 0,

            'favoriteApartmentCount' => $this->FavoriteApartmentCount ?? 0,
            'favoriteDeveloperApartmentCount' => $this->FavoriteDeveloperApartmentCount ?? 0,
            'favoriteAgencyApartmentCount' => $this->FavoriteAgencyApartmentCount ?? 0,
            'favoriteComplexCount' => $this->FavoriteComplexCount ?? 0,

            'inApartmentDialogueCount' => $this->inApartmentDialogueCount ?? 0,
            'outApartmentDialogueCount' => $this->outApartmentDialogueCount ?? 0,
            'markerApartmentDialogueCount' => $this->markerApartmentDialogueCount ?? 0,
            'archiveApartmentDialogueCount' => $this->archiveApartmentDialogueCount ?? 0,

            'unViewedInDialogueCount' => $this->UnViewedInDialogueCount ?? 0,
            'unViewedOutDialogueCount' => $this->UnViewedOutDialogueCount ?? 0,
            'unViewedMarkerDialogueCount' => $this->UnViewedMarkerDialogueCount ?? 0,
            'unViewedArchiveDialogueCount' => $this->UnViewedArchiveDialogueCount ?? 0,

            'company' => CompanyResource::make($this->whenLoaded('company')),
            'companyManageType' => $this->manage_type,
            'companyManageTypeTranslate' => $this->manage_type ? trans('enums.userPosition.' . $this->manage_type) : null,

            'agency' => AgencyResource::make($this->whenLoaded('agency')),
            'agencyManageType' => $this->agency_manage_type,
            'agencyManageTypeTranslate' => $this->agency_manage_type ? trans('enums.userPosition.' . $this->agency_manage_type) : null,

            'privateType' => $this->private_type,
            'privateTypeTranslate' => $this->private_type ? trans('enums.userPosition.' . $this->private_type) : null,

            'achievementCount' => $this->achievementCount ?? 0,
        ];
    }
}
