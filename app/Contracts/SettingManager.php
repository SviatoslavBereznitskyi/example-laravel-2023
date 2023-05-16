<?php

declare(strict_types=1);

namespace App\Contracts;

interface SettingManager
{
    public function setting($key);
}
