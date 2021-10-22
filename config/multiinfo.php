<?php

declare(strict_types=1);

return [
    'connection' => env('MULTIINFO_CONNECTION', 'http'),

    'api_version' => env('MULTIINFO_API_VERSION'),

    'credentials' => [
        'login'      => env('MULTIINFO_CREDENTIALS_LOGIN'),
        'password'   => env('MULTIINFO_CREDENTIALS_PASSWORD'),
        'service_id' => env('MULTIINFO_CREDENTIALS_SERVICE_ID'),
    ],

    'certificate' => [
        'public_key_path'  => env('MULTIINFO_CERTIFICATE_PUBLIC_KEY_PATH'),
        'private_key_path' => env('MULTIINFO_CERTIFICATE_PRIVATE_KEY_PATH'),
        'password'         => env('MULTIINFO_CERTIFICATE_PASSWORD'),
        'type'             => env('MULTIINFO_CERTIFICATE_TYPE'),
    ],
];
