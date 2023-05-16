<?php

declare(strict_types=1);

use function App\env;

return [
    'tron' => [
        'network-host' => env('TRON_NETWORK_HOST'),
        'contract-address' => env('TRON_CONTACT_ADDRESS'),
        'owner-address' => env('TRON_OWNER_ADDRESS'),
        'private_key' => env('TRON_PRIVATE_KEY'),
    ],
];
