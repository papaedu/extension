<?php

return [
    'secret_id' => env('TENCENT_CLOUD_SECRET_ID'),
    'secret_key' => env('TENCENT_CLOUD_SECRET_KEY'),
    'region' => env('TENCENT_CLOUD_REGION'),

    'captcha' => [
        'app_id' => env('TENCENT_CLOUD_CAPTCHA_APP_ID'),
        'app_secret_key' => env('TENCENT_CLOUD_CAPTCHA_APP_SECRET_KEY'),
    ],

    'cos' => [
        'default' => [
            'region' => env('TENCENT_CLOUD_COS_REGION'),
            'bucket' => env('TENCENT_CLOUD_COS_IMAGE_BUCKET'),
            'domain' => env('TENCENT_CLOUD_COS_IMAGE_DOMAIN'),
        ],
        'image' => [
            'region' => env('TENCENT_CLOUD_COS_REGION'),
            'bucket' => env('TENCENT_CLOUD_COS_IMAGE_BUCKET'),
            'domain' => env('TENCENT_CLOUD_COS_IMAGE_DOMAIN'),
        ],
        'audio' => [
            'region' => env('TENCENT_CLOUD_COS_REGION'),
            'bucket' => env('TENCENT_CLOUD_COS_AUDIO_BUCKET'),
            'domain' => env('TENCENT_CLOUD_COS_AUDIO_DOMAIN'),
        ],
        'video' => [
            'region' => env('TENCENT_CLOUD_COS_REGION'),
            'bucket' => env('TENCENT_CLOUD_COS_VIDEO_BUCKET'),
            'domain' => env('TENCENT_CLOUD_COS_VIDEO_DOMAIN'),
        ],
        'file' => [
            'region' => env('TENCENT_CLOUD_COS_REGION'),
            'bucket' => env('TENCENT_CLOUD_COS_FILE_BUCKET'),
            'domain' => env('TENCENT_CLOUD_COS_FILE_DOMAIN'),
        ],
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

    'tiw' => [
        // 'secret_id' => env('TENCENT_CLOUD_SECRET_ID'),
        // 'secret_key' => env('TENCENT_CLOUD_SECRET_KEY'),
        // 'region' => env('TENCENT_CLOUD_REGION'),
        'sdk_app_id' => intval(env('TENCENT_CLOUD_TIW_SDK_APP_ID')),
        'transcode_callback_key' => env('TENCENT_CLOUD_TIW_TRANSCODE_CALLBACK_KEY'),
        'record_callback_key' => env('TENCENT_CLOUD_TIW_RECORD_CALLBACK_KEY'),
        'push_callback_key' => env('TENCENT_CLOUD_TIW_PUSH_CALLBACK_KEY'),
    ],

    'trtc' => [
        // 'secret_id' => env('TENCENT_CLOUD_SECRET_ID'),
        // 'secret_key' => env('TENCENT_CLOUD_SECRET_KEY'),
        // 'region' => env('TENCENT_CLOUD_REGION'),
        'sdk_app_id' => intval(env('TENCENT_CLOUD_TRTC_SDK_APP_ID')),
        'callback_key' => env('TENCENT_CLOUD_TRTC_CALLBACK_KEY'),
    ],

    'vod' => [
        // 'secret_id' => env('TENCENT_CLOUD_SECRET_ID'),
        // 'secret_key' => env('TENCENT_CLOUD_SECRET_KEY'),
        // 'region' => env('TENCENT_CLOUD_REGION'),
        'host' => env('TENCENT_CLOUD_VOD_HOST'),
        'sub_app_id' => intval(env('TENCENT_CLOUD_VOD_SUB_APP_ID')),
    ],
];
