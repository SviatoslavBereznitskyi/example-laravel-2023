<?php

declare(strict_types=1);

use function App\env;

return [
    'monobank_token' => env('MONOBANK_TOKEN'),
    'back_redirect' => env('MONOBANK_REDIRECT', 'http://localhost/order/'),
    'liqpay_public_key' => env('LIQPAY_PUBLIC_KEY'),
    'liqpay_private_key' => env('LIQPAY_PRIVATE_KEY'),
];
