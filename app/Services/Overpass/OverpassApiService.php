<?php

declare(strict_types=1);

namespace App\Services\Overpass;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class OverpassApiService
{
    private string $path = 'https://overpass-api.de/api/interpreter';

    public function __construct(private DenormalizerInterface $denormalizer)
    {
    }

    /**
     * @return Collection|NodeDto[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getCityStreet(string $name): Collection
    {
        $httpClient = new Client();

        try {
            $response = $httpClient->get($this->path, [
                'headers' => [
                    'content-type' => 'text/plain',
                ],
                'body' => '[out:json]; area[name = "' . $name . '"]; (way(area)["highway"~"^(motorway|trunk|primary|secondary|unclassified|residential|living_street|service|pedestrian)$"];>;); out;',
            ]);
        } catch (ClientException $exception) {
            dd($exception->getResponse()->getBody()->getContents());
        }

        $content = json_decode($response->getBody()->getContents(), true);
        /** @var NodeDto $nodes */
        $nodes = $this->denormalizer->denormalize($content['elements'], NodeDto::class . '[]');

        return collect($nodes);
    }
}
