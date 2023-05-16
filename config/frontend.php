<?php

declare(strict_types=1);

use function App\env;

return [
    'url' => env('FRONTEND_URL'),
    'url_apartment' => env('FRONTEND_URL') . '/object/',
    'url_apartment_moderation' => env('FRONTEND_URL') . '/cabinet/announcement/moderation',
    'url_blog' => env('FRONTEND_URL') . '/blog/all/',
    'url_dialog' => env('FRONTEND_URL') . '/cabinet/dialogues/message/sent/',
    'url_complex' => env('FRONTEND_URL') . '/complexes/',
];
