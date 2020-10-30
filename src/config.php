<?php

return [
    'auth' => [
        'nickname_prefix' => '用户',

        'captcha' => [
            'length' => 4,
            'ttl' => 300,
        ],

        'socialite' => [
            'model' => App\Models\Socialite::class,
            'type' => App\Enums\SocialiteType::class,
        ],
    ],
];