<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SymfonyValidatorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ValidatorInterface::class, static function () {
            return Validation::createValidatorBuilder()
                ->enableAnnotationMapping()
                ->getValidator();
        });
    }
}
