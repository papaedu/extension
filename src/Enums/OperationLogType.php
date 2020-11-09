<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class OperationLogType extends Enum
{
    const RegisterByPassword = 11;

    const RegisterByCaptcha = 12;

    const RegisterByOnelogin = 13;

    const LoginByPassword = 21;

    const LoginByCaptcha = 22;

    const LoginByOnelogin = 23;

    const LoginBySocialiteWeChat = 24;

    const Logout = 31;

    const ForgotPassword = 41;

    const ResetPassword = 42;

    const ResetMobile = 43;

    public static function getDescription($value): string
    {
        if ($value === self::RegisterByPassword) {
            return '注册';
        }
        if ($value === self::RegisterByCaptcha) {
            return '注册（验证码登录）';
        }
        if ($value === self::RegisterByOnelogin) {
            return '注册（一键登录）';
        }
        if ($value === self::LoginByPassword) {
            return '密码登录';
        }
        if ($value === self::LoginByCaptcha) {
            return '验证码登录';
        }
        if ($value === self::LoginByOnelogin) {
            return '一键登录';
        }
        if ($value === self::LoginBySocialiteWeChat) {
            return '社会化登录（微信）';
        }
        if ($value === self::Logout) {
            return '登出';
        }
        if ($value === self::ForgotPassword) {
            return '忘记密码';
        }
        if ($value === self::ResetPassword) {
            return '重置密码';
        }
        if ($value === self::ResetMobile) {
            return '重置手机';
        }

        return parent::getDescription($value);
    }
}
