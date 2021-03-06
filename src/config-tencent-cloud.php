<?php

return [
    'secret_id' => env('TENCENT_CLOUD_SECRET_ID'),
    'secret_key' => env('TENCENT_CLOUD_SECRET_KEY'),

    'captcha' => [
        'app_id' => env('TENCENT_CLOUD_CAPTCHA_APP_ID'),
        'app_secret_key' => env('TENCENT_CLOUD_CAPTCHA_APP_SECRET_KEY'),
    ],

    'tim' => [
        'sdk_app_id' => env('TENCENT_CLOUD_TIM_SDK_APP_ID'),
        'identifier' => env('TENCENT_CLOUD_TIM_IDENTIFIER'),

        'sign' => [
            'version' => env('TENCENT_CLOUD_TIM_SIGN_VERSION'),
            'key' => env('TENCENT_CLOUD_TIM_KEY'),
            'private_key' => env('TENCENT_CLOUD_TIM_PRIVATE_KEY', ''),
            'public_key' => env('TENCENT_CLOUD_TIM_PUBLIC_KEY', ''),
        ],

        'offline_push' => [
            'android_info' => [
                'oppo_channel_id' => env('TENCENT_CLOUD_TIM_OPPO_CHANNEL_ID'),
                'xiaomi_channel_id' => env('TENCENT_CLOUD_TIM_XIAOMI_CHANNEL_ID'),
            ],
        ],
    ],

    'vod' => [
        'host' => env('TENCENT_CLOUD_VOD_URL'),
    ],
];
