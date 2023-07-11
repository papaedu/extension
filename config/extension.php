<?php

return [
    'web_url' => env('WEB_URL'),
    'wap_url' => env('WAP_URL'),

    'auth' => [
        'nickname_prefix' => '用户',

        'captcha' => [
            'sms_template_id' => [
                'domestic' => [
                    'aliyun' => '',
                    'qcloud' => '',
                ],
                'foreign' => [
                    'aliyun' => '',
                    'qcloud' => '',
                ],
            ],
            'length' => 6,
            'ttl' => 300,
        ],
    ],

    // useless
    'filesystem' => [
        'delete_blocklist' => [
            'system/',
        ],
    ],

    'aes' => [
        'key' => env('EXTENSION_AES_KEY'),
    ],

    'device' => [
        'ban_list' => 'd:b',
    ],

    // deprecated
    'socialite' => [
        'type' => 10,
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

    'media_library' => [
        'ban' => [
            'dir' => 'system/ban/',
            'file' => [
                'default' => [
                    'path' => 'default.png',
                    'width' => 0,
                    'height' => 0,
                ],
                'avatar' => [
                    'path' => 'avatar.png',
                ],
            ],
        ],
    ],

    'log' => [
        'response' => [
            'channel_name' => env('EXTENSION_RESPONSE_LOG_CHANNEL_NAME', 'resplog'),
        ],
    ],

    'whitelist' => [
        'ips' => explode(',', env('EXTENSION_WHITELIST_IPS', '')),
        'enable' => env('EXTENSION_WHITELIST_ENABLE', true),
    ],

    'header' => [
        'keys' => explode(',', env('EXTENSION_HEADER_KEYS', '')),
        'secret' => env('EXTENSION_HEADER_SECRET'),
    ],
];
