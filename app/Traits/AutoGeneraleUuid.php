<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;

trait AutoGeneraleUuid
{
    protected static function boot(): void
    {
        parent::boot();
        static::creating(static function ($model): void {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
}
