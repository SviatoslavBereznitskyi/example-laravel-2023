<?php

declare(strict_types=1);

namespace App\Services\Overpass;

use Str;

class NodeDto
{
    public string $type = '';
    public string|int $id;
    /**
     * @var float|int|string|null
     */
    public string|float|null $lat;
    /**
     * @var float|int|string|null
     */
    public string|float|null $lon;
    public ?array $nodes = null;
    public ?StreetDto $tags = null;

    public function setTags(?array $tags): void
    {
        if (!$tags) {
            return;
        }

        if (isset($tags['highway'])) {
            $street = new StreetDto();
            $names = [];
            foreach ($tags as $key => $tag) {
                if (Str::contains($key, 'name')) {
                    $names[$key] = $tag;
                }
            }
            if (empty($names)) {
                return;
            }
            $street->names = $names;
            $this->tags = $street;
        }

        if (isset($tags['names'])) {
            $street = new StreetDto();
            $street->names = $tags['names'];
            $this->tags = $street;
        }
    }
}
