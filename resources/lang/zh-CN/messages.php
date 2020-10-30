<?php

return [
    'field' => [
        'username' => '用户名',
        'password' => '密码',
        'captcha' => '验证码',
    ],

    'auth' => [
        'failed' => '用户名或密码错误',
        'one_login_failed' => '一键登录失败',
        'throttle' => '尝试登录次数过多，请:seconds秒后再试',

        'registered' => '此:attribute已经注册',

        'captcha_failed' => ':attribute错误',
    ],

    'socialite' => [
        'bind_failed' => '绑定发生异常',
        'wechat' => [
            'already_bind' => '此微信已绑定其他手机号',
            'already_be_bind' => '此手机号已绑定其他微信',
        ],
    ],

    'validator' => [
        'image_exists' => ':attribute不存在或上传失败',
        'audio_exists' => ':attribute不存在或上传失败',
        'file_exists' => ':attribute不存在或上传失败',
        'mobile' => ':attribute格式错误',
        'password_strength' => ':attribute必须包含数字，且必须包含字母或其它符号（!@_#$%^&*()-+=,.?）',
        'multiple_of' => ':attribute格式错误',
        'required_multiple_if' => ':attribute不能为空',
    ],
];