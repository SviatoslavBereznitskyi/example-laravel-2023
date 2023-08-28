<?php

declare(strict_types=1);

namespace App;

/**
 * @param bool|float|int|string|null $default
 * @return string
 */
function env(string $name, mixed $default = null): mixed
{
    $value = getenv($name);

    if ($value !== false) {
        return $value;
    }

    $file = getenv($name . '_FILE');

    if ($file !== false) {
        return trim(file_get_contents($file));
    }

    if ($default !== null) {
        return $default;
    }


    //test
    return null;
}
