<?php

declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\User\Wallet.
 *
 * @property string $id
 * @property int $silver_points
 * @property int $gold_points
 * @property int $cash
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newQuery()
 * @method static \Illuminate\Database\Query\Builder|Wallet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereGoldPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereSilverPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Wallet withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Wallet withoutTrashed()
 * @mixin \Eloquent
 */
class Wallet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'silver_points',
        'gold_points',
        'cash',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSilverPointsAttribute(int $value): float
    {
        return $value / 100;
    }

    public function setSilverPointsAttribute(float $value): int
    {
        return $this->attributes['silver_points'] = (int)($value * 100);
    }

    public function getGoldPointsAttribute(int $value): float
    {
        return $value / 100;
    }

    public function setGoldPointsAttribute(float $value): int
    {
        return $this->attributes['gold_points'] = (int)($value * 100);
    }

    public function getCashAttribute(int $value): float
    {
        return $value / 100;
    }

    public function setCashAttribute(float $value): int
    {
        return $this->attributes['cash'] = (int)($value * 100);
    }
}
