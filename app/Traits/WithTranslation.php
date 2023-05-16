<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait WithTranslation
{
    public function getAll(): Collection
    {
        return $this->model::withTranslation()->get();
    }
}
