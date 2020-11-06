<?php

return [
    'auth' => [
        'nickname_prefix' => '用户',

        'captcha' => [
            'sms_template_id' => 'SMS_158490336',
            'length' => 4,
            'ttl' => 300,
        ],

        'socialite' => [
            'model' => App\Models\Socialite::class,
            'type' => App\Enums\SocialiteType::class,
        ],
    ],
];