<?php

return [
    'auth' => [
        'nickname_prefix' => '用户',

        'captcha' => [
            'sms_template_id' => [
                'domestic' => [
                    'aliyun' => 'SMS_205825878',
                    'qcloud' => '',
                ],
                'foreign' => [
                    'aliyun' => '',
                    'qcloud' => '785556',
                ],
            ],
            'length' => 4,
            'ttl' => 300,
        ],
    ],

    'socialite' => [
        'model' => App\Models\Socialite::class,
        'type' => App\Enums\SocialiteType::class,
        'channel' => [
            'wechat' => [
                'sync_nickname' => true,
                'sync_avatar' => true,
            ],
        ],
    ],

    'locale' => [
        'idd_code' => 86,
        'iso_code' => 'CN',
    ],

    'enable_global_phone' => true,

    'image' => [
        'ban' => [
            'avatar' => 'system/ban/avatar.png',
            '2x1' => 'system/ban/photo-2x1.png',
        ],
    ],

    'whitelist' => [
        'ip' => env('EXTENSION_WHITELIST_IP'),
        'enable' => env('EXTENSION_WHITELIST_ENABLE', true),
    ],
];