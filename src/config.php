<?php

return [
    'web_url' => env('WEB_URL'),
    'wap_url' => env('WAP_URL'),

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

    'device' => [
        'ban_list' => 'd:b',
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

    'header' => [
        'keys' => explode(',', env('EXTENSION_HEADER_KEYS')),
        'verify_type' => env('EXTENSION_HEADER_VERIFY_TYPE'),
        'secret' => env('EXTENSION_HEADER_SECRET'),
        'public_key_path' => env('EXTENSION_PUBLIC_KEY_PATH'),
    ],
];
