<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->initSerializers();
    }

    public function initSerializers(): void
    {
        $serializerInitClosure = static function () {
            $encoders = [
                new JsonEncoder(),
            ];
            $reflectionExtractor = new ReflectionExtractor();
            $phpDocExtractor = new PhpDocExtractor();
            $propertyTypeExtractor = new PropertyInfoExtractor(
                [$reflectionExtractor],
                [$phpDocExtractor, $reflectionExtractor],
                [$phpDocExtractor],
                [$reflectionExtractor],
                [$reflectionExtractor]
            );

            $normalizers = [
                new ArrayDenormalizer(),
                new ObjectNormalizer(null, null, null, $propertyTypeExtractor),
            ];

            return new Serializer($normalizers, $encoders);
        };

        $this->app->singleton(SerializerInterface::class, $serializerInitClosure);
        $this->app->singleton(NormalizerInterface::class, $serializerInitClosure);
        $this->app->singleton(DenormalizerInterface::class, $serializerInitClosure);
    }
}
