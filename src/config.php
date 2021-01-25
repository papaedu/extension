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
            'length' => 6,
            'ttl' => 300,
        ],
    ],

    'socialite' => [
        'model' => Papaedu\Extension\Models\Socialite::class,
        'type' => Papaedu\Extension\Enums\SocialiteType::class,
        'channel' => [
            'wechat' => [
                'sync_nickname' => true,
                'sync_avatar' => true,
                'enable_union_id' => false,
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

    'qcloud' => [
        'captcha' => [
            'begin' => [
                'app_id' => env('QCLOUD_CAPTCHA_APP_ID'),
                'app_secret_key' => env('QCLOUD_CAPTCHA_APP_SECRET_KEY'),
            ],
        ],
    ],
];
