<?php

declare(strict_types=1);

namespace App\Traits;

use Astrotomic\Translatable\Translatable as AstrotomicTranslatable;
use Illuminate\Support\Str;

trait Translatable
{
    use AstrotomicTranslatable;

    protected function getAttributeAndLocale(string $key): array
    {
        if (Str::contains($key, ':')) {
            return explode(':', $key);
        }

        if (Str::contains($key, '-')) {
            return explode('-', $key);
        }

        return [$key, $this->locale()];
    }
}
