<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Support\Facades\Redis;
use Papaedu\Extension\Support\Extend;

class CaptchaValidator
{
    /**
     * @param  string  $username
     * @param  string  $ISOCode
     * @return string
     */
    public static function generate(string $username, string $ISOCode): string
    {
        $captcha = Extend::randomNumeric(config('extension.auth.captcha.length'));
        Redis::setex(static::getKey($username, $ISOCode), config('extension.auth.captcha.ttl'), $captcha);

        return $captcha;
    }

    /**
     * @param  string  $username
     * @param  string  $ISOCode
     * @param  string  $captcha
     * @return bool
     */
    public static function validate(string $username, string $ISOCode, string $captcha): bool
    {
        return Redis::get(static::getKey($username, $ISOCode)) == $captcha;
    }

    /**
     * @param  string  $username
     * @param  string  $ISOCode
     */
    public static function clean(string $username, string $ISOCode): void
    {
        Redis::del(static::getKey($username, $ISOCode));
    }

    /**
     * @param  string  $username
     * @param  string  $ISOCode
     */
    public static function createPassToken(string $username, string $ISOCode): void
    {
        Redis::setex(static::getTokenKey($username, $ISOCode), config('extension.auth.captcha.ttl'), 1);
    }

    /**
     * @param  string  $username
     * @param  string  $ISOCode
     * @return bool
     */
    public static function checkPassToken(string $username, string $ISOCode): bool
    {
        return Redis::exists(static::getTokenKey($username, $ISOCode));
    }

    /**
     * @param  string  $username
     * @param  string  $ISOCode
     */
    public static function cleanPassToken(string $username, string $ISOCode): void
    {
        Redis::del(static::getTokenKey($username, $ISOCode));
    }

    protected static function getKey(string $username, string $ISOCode): string
    {
        $key = "captcha_{$username}";
        if ($ISOCode) {
            $key .= "_{$ISOCode}";
        }

        return $key;
    }

    protected static function getTokenKey(string $username, string $ISOCode): string
    {
        $key = "captcha_token_{$username}";
        if ($ISOCode) {
            $key .= "_{$ISOCode}";
        }

        return $key;
    }
}
