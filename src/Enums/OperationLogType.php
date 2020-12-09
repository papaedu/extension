<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class OperationLogType extends Enum
{
    const REGISTER_BY_PASSWORD = 11;

    const REGISTER_BY_CAPTCHA = 12;

    const REGISTER_BY_ONELOGIN = 13;

    const LOGIN_BY_PASSWORD = 21;

    const LOGIN_BY_CAPTCHA = 22;

    const LOGIN_BY_ONELOGIN = 23;

    const LOGIN_BY_SOCIALITE_WECHAT = 24;

    const LOGOUT = 31;

    const FORGOT_PASSWORD = 41;

    const RESET_PASSWORD = 42;

    const RESET_USERNAME = 43;

    public static function getDescription($value): string
    {
        if ($value === self::REGISTER_BY_PASSWORD) {
            return '注册';
        }
        if ($value === self::REGISTER_BY_CAPTCHA) {
            return '注册（验证码登录）';
        }
        if ($value === self::REGISTER_BY_ONELOGIN) {
            return '注册（一键登录）';
        }
        if ($value === self::LOGIN_BY_PASSWORD) {
            return '密码登录';
        }
        if ($value === self::LOGIN_BY_CAPTCHA) {
            return '验证码登录';
        }
        if ($value === self::LOGIN_BY_ONELOGIN) {
            return '一键登录';
        }
        if ($value === self::LOGIN_BY_SOCIALITE_WECHAT) {
            return '社会化登录（微信）';
        }
        if ($value === self::LOGOUT) {
            return '登出';
        }
        if ($value === self::FORGOT_PASSWORD) {
            return '忘记密码';
        }
        if ($value === self::RESET_PASSWORD) {
            return '重置密码';
        }
        if ($value === self::RESET_USERNAME) {
            return '重置用户名';
        }

        return parent::getDescription($value);
    }
}
