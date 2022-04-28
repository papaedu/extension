<?php

namespace Papaedu\Extension\Enums;

use Papaedu\Extension\Enums\Traits\Label;

enum OperationLogType: int
{
    use Label;

    case REGISTER_BY_PASSWORD = 11;

    case REGISTER_BY_CAPTCHA = 12;

    case REGISTER_BY_ONELOGIN = 13;

    case LOGIN_BY_PASSWORD = 21;

    case LOGIN_BY_CAPTCHA = 22;

    case LOGIN_BY_ONELOGIN = 23;

    case LOGIN_BY_SOCIALITE_WECHAT = 24;

    case LOGOUT = 31;

    case FORGOT_PASSWORD = 41;

    case RESET_PASSWORD = 42;

    case RESET_USERNAME = 43;

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::REGISTER_BY_PASSWORD => '注册',
            self::REGISTER_BY_CAPTCHA => '注册（验证码登录）',
            self::REGISTER_BY_ONELOGIN => '注册（一键登录）',
            self::LOGIN_BY_PASSWORD => '密码登录',
            self::LOGIN_BY_CAPTCHA => '验证码登录',
            self::LOGIN_BY_ONELOGIN => '一键登录',
            self::LOGIN_BY_SOCIALITE_WECHAT => '社会化登录（微信）',
            self::LOGOUT => '登出',
            self::FORGOT_PASSWORD => '忘记密码',
            self::RESET_PASSWORD => '重置密码',
            self::RESET_USERNAME => '重置用户名',
        };
    }
}
