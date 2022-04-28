<?php

return [
    'uid' => env('ALIBABA_CLOUD_UID'),
    'access_key_id' => env('ALIBABA_CLOUD_ACCESS_KEY_ID'),
    'access_key_secret' => env('ALIBABA_CLOUD_ACCESS_KEY_SECRET'),
    'region_id' => env('ALIBABA_CLOUD_REGION_ID', 'cn-hangzhou'),

    'green' => [
        'biz_type' => env('ALIBABA_CLOUD_GREEN_BIZ_TYPE'),
        'seed' => env('ALIBABA_CLOUD_GREEN_SEED'),
        'scenes' => [
            'image' => explode(',', env('ALIBABA_CLOUD_GREEN_SCENE_IMAGE', '')),
        ],
        'callback' => env('ALIBABA_CLOUD_GREEN_CALLBACK'),
    ],

    'sts' => [
        'oss' => [
            'access_key_id' => env('OSS_ACCESS_KEY_ID'),
            'access_key_secret' => env('OSS_ACCESS_KEY_SECRET'),
            'region_id' => env('OSS_REGION_ID', 'cn-hangzhou'),
            'role_arn' => env('OSS_ROLE_ARN'),
            'role_session_name' => env('OSS_ROLE_SESSION_NAME'),
        ],
    ],
];
