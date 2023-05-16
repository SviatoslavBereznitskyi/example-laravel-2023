<?php

declare(strict_types=1);

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Catalog\Agency\Agency;
use App\Models\Catalog\Apartment;
use App\Models\Catalog\Company\Company;
use App\Models\Catalog\Company\ResidentialComplex\ResidentialComplex;
use App\Models\Charity\Charity;
use App\Models\Notary\Notary;
use App\Models\Raffle\RaffleMemberPool;
use App\Models\Settings\DeleteReason;
use App\Models\Settings\Enums\CurrencyEnum;
use App\Models\Tasks\TaskCompleted;
use App\Models\User\Enums\TransactionReasonEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Str;

/**
 * App\Models\User.
 *
 * @property string $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $number
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Notifications\DatabaseNotification[]|\Illuminate\Notifications\DatabaseNotificationCollection $notifications
 * @property int|null $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $phone
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @property \App\Models\User\OtpCode[]|\Illuminate\Database\Eloquent\Collection $otpCodes
 * @property int|null $otp_codes_count
 * @property bool $email_confirmed
 * @property bool $phone_confirmed
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneConfirmed($value)
 * @property bool $terms_of_use_accepted
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTermsOfUseAccepted($value)
 * @property \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property int|null $clients_count
 * @property \App\Models\User\SocialUser[]|\Illuminate\Database\Eloquent\Collection $socialUsers
 * @property int|null $social_users_count
 * @property int $visible_id
 * @property string|null $surname
 * @property string|null $sex
 * @property string|null $birthday
 * @property string|null $additional_phone
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdditionalPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVisibleId($value)
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @property Collection|Document[] $documents
 * @property int|null $documents_count
 * @property string|null $avatar_path
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatarPath($value)
 * @property string|null $delete_reason_id
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeleteReasonId($value)
 * @property DeleteReason|null $deleteReason
 * @property Wallet|null $wallet
 * @property Collection|Transaction[] $transactions
 * @property int|null $transactions_count
 * @property int $exchange_limit
 * @method static \Illuminate\Database\Eloquent\Builder|User whereExchangeLimit($value)
 * @property int $exchange_limit_used
 * @property Collection|RaffleMemberPool[] $tickets
 * @property int|null $tickets_count
 * @property Collection|Company[] $companies
 * @property int|null $companies_count
 * @property Charity[]|Collection $Charities
 * @property int|null $charities_count
 * @property bool $is_instructed
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsInstructed($value)
 * @property Collection|UserSocialToken[] $socialTokens
 * @property int|null $social_tokens_count
 * @property Collection|TaskCompleted[] $completedTasks
 * @property int|null $completed_tasks_count
 * @property Agency[]|Collection $agencies
 * @property int|null $agencies_count
 * @property Collection|Subscription[] $subscriptions
 * @property int|null $subscriptions_count
 * @property Collection|Order[] $orders
 * @property int|null $orders_count
 * @property Charity[]|Collection $charities
 * @property string $role
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @property string|null $facebook_id
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFacebookId($value)
 * @property \App\Models\User\RBAC\Permission[]|Collection $permissions
 * @property int|null $permissions_count
 * @property \App\Models\User\RBAC\Role[]|Collection $roles
 * @property int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @property \App\Models\User\Dialogue[]|Collection $archiveDialogues
 * @property int|null $archive_dialogues_count
 * @property int $visited_in_row
 * @property Carbon|null $visited_at
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVisitedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVisitedInRow($value)
 * @property bool $reward_claimed
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRewardClaimed($value)
 * @property Apartment[]|Collection $apartments
 * @property int|null $apartments_count
 * @property \App\Models\User\Dialogue[]|Collection $dialogues
 * @property int|null $dialogues_count
 * @property Apartment[]|Collection $favoriteApartments
 * @property int|null $favorite_apartments_count
 * @property \App\Models\User\UserApartmentSubscription[]|Collection $apartmentSubscriptions
 * @property int|null $apartment_subscriptions_count
 * @property \App\Models\User\Achievement[]|Collection $achievements
 * @property int|null $achievements_count
 * @property Collection|Notary[] $notaries
 * @property int|null $notaries_count
 * @property \App\Models\User\Dialogue[]|Collection $apartmentDialogues
 * @property int|null $apartment_dialogues_count
 * @property \App\Models\User\Dialogue[]|Collection $markerDialogues
 * @property int|null $marker_dialogues_count
 * @property bool|null $fill_profile
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFillProfile($value)
 * @property Collection|ResidentialComplex[] $favoriteComplexes
 * @property int|null $favorite_complexes_count
 * @property string|null $manage_type
 * @property string|null $company_id
 * @property Company|null $company
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereManageType($value)
 * @property string|null $agency_manage_type
 * @property string|null $agency_id
 * @property Agency|null $agency
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgencyManageType($value)
 * @property string|null $private_type
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePrivateType($value)
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    public const ADMIN = 'admin';
    public const USER = 'user';
    public const MANAGER = 'manager';
    public const EXPIRED_IN_TOKEN = 'PT1800S';

    protected $fillable = [
        'id',
        'name',
        'surname',
        'email',
        'sex',
        'phone',
        'password',
        'terms_of_use_accepted',
        'visible_id',
        'birthday',
        'additional_phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
        'visited_at' => 'datetime',
    ];

    protected $keyType = 'string';

    protected $observables = ['completeProfile'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = Str::lower($value);
    }

    public function otpCodes(): HasMany
    {
        return $this->hasMany(OtpCode::class);
    }

    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)->orWhere('phone', $identifier)->first();
    }

    public function socialUsers(): HasMany
    {
        return $this->hasMany(SocialUser::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function deleteReason(): BelongsTo
    {
        return $this->belongsTo(DeleteReason::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function routeNotificationForSms()
    {
        return $this->phone;
    }

    public function changePassword(string $password): self
    {
        $this->password = Hash::make($password);

        return $this;
    }

    public function acceptTermOfUse(): self
    {
        $this->terms_of_use_accepted = true;

        return $this;
    }

    public function acceptInstruction(): self
    {
        $this->is_instructed = true;

        return $this;
    }

    public function getExchangeLimitUsedAttribute(): int
    {
        return $this->transactions->where('currency_type', CurrencyEnum::GOLDEN_POINT->value)
            ->where('reason', TransactionReasonEnum::Exchange->value)
            ->where('created_at', '>', Carbon::now()->startOfWeek())
            ->count();
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(RaffleMemberPool::class, 'user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function charities(): BelongsToMany
    {
        return $this->belongsToMany(Charity::class, 'charity_members', 'member_id', 'charity_id')->withPivot(['count', 'updated_at']);
    }

    public function socialTokens(): HasMany
    {
        return $this->hasMany(UserSocialToken::class, 'user_id');
    }

    public function completedTasks(): HasMany
    {
        return $this->hasMany(TaskCompleted::class);
    }

    public function agencies(): BelongsToMany
    {
        return $this->belongsToMany(Agency::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function archiveDialogues(): BelongsToMany
    {
        return $this->belongsToMany(Dialogue::class, 'archive_dialogue');
    }

    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }

    public function favoriteApartments(): BelongsToMany
    {
        return $this->belongsToMany(Apartment::class, 'apartment_favorite');
    }

    public function dialogues(): HasMany
    {
        return $this->hasMany(Dialogue::class);
    }

    public function apartmentDialogues(): HasManyThrough
    {
        return $this->hasManyThrough(Dialogue::class, Apartment::class);
    }

    public function markerDialogues(): BelongsToMany
    {
        return $this->belongsToMany(Dialogue::class, 'marker_dialogue');
    }

    public function apartmentSubscriptions(): HasMany
    {
        return $this->hasMany(UserApartmentSubscription::class);
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'user_achievement')->withTimestamps();
    }

    public function notaries(): HasMany
    {
        return $this->hasMany(Notary::class);
    }

    public function isCompleteProfile(): bool
    {
        return
            $this->name
            && $this->surname
            && $this->email
            && $this->email_confirmed
            && $this->phone
            && $this->phone_confirmed
            && ($this->private_type || $this->company_id || $this->agency_id)
            && $this->sex
            && $this->birthday
            && $this->socialUsers()->exists()
            && $this->avatar_path;
    }

    public function completeProfile(): void
    {
        $this->fireModelEvent('completeProfile', false);
    }

    public function favoriteComplexes(): BelongsToMany
    {
        return $this->belongsToMany(ResidentialComplex::class, 'complex_favorite');
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }
}
