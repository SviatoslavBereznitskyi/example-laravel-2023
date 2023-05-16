<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Http\Resources\Catalog\Agency\AgencyResource;
use App\Http\Resources\Catalog\Company\CompanyResource;
use App\Models\Catalog\Enums\ApartmentUserTypeEnum;
use App\Models\User\Enums\AgencyManageTypeEnum;
use App\Models\User\Enums\ManageTypeEnum;
use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: self::class,
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'visibleId', type: 'integer'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'surname', type: 'string'),
        new OA\Property(property: 'sex', type: 'string'),
        new OA\Property(property: 'email', type: 'string', format: 'email'),
        new OA\Property(property: 'phone', type: 'string'),
        new OA\Property(property: 'avatarUrl', type: 'string', format: 'uri'),
        new OA\Property(property: 'additionalPhone', type: 'string'),
        new OA\Property(property: 'createdAt', type: 'date'),

        new OA\Property(property: 'company', ref: '#/components/schemas/' . CompanyResource::class, type: 'object'),
        new OA\Property(property: 'companyManageType', type: 'string', enum: [ManageTypeEnum::MANAGER, ManageTypeEnum::DIRECTOR]),
        new OA\Property(property: 'companyManageTypeTranslate', type: 'string'),

        new OA\Property(property: 'agency', ref: '#/components/schemas/' . AgencyResource::class, type: 'object'),
        new OA\Property(property: 'agencyManageType', type: 'string', enum: [AgencyManageTypeEnum::HEAD, AgencyManageTypeEnum::REALTOR]),
        new OA\Property(property: 'agencyManageTypeTranslate', type: 'string'),

        new OA\Property(property: 'privateType', type: 'string', enum: [ApartmentUserTypeEnum::PrivateRealtor, ApartmentUserTypeEnum::PrivatePerson]),
        new OA\Property(property: 'privateTypeTranslate', type: 'string'),

        new OA\Property(property: 'visitedAt', type: 'date'),
    ],
    type: 'object'
)]
class UserShortResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var User $this */
        return [
            'id' => $this->id,
            'visibleId' => $this->visible_id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone' => $this->phone,
            'additionalPhone' => $this->additional_phone,
            'avatarUrl' => $this->avatar_path,
            'sex' => $this->sex,

            'createdAt' => $this->created_at,

            'company' => CompanyResource::make($this->whenLoaded('company')),
            'companyManageType' => $this->manage_type,
            'companyManageTypeTranslate' => $this->manage_type ? trans('enums.userPosition.' . $this->manage_type) : null,

            'agency' => AgencyResource::make($this->whenLoaded('agency')),
            'agencyManageType' => $this->agency_manage_type,
            'agencyManageTypeTranslate' => $this->agency_manage_type ? trans('enums.userPosition.' . $this->agency_manage_type) : null,

            'privateType' => $this->private_type,
            'privateTypeTranslate' => $this->private_type ? trans('enums.userPosition.' . $this->private_type) : null,

            'visitedAt' => $this->visited_at,
        ];
    }
}
