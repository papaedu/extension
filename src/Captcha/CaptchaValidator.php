<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Support\Facades\Redis;
use Papaedu\Extension\Support\Extend;

class CaptchaValidator
{
    /**
     * @param  int  $ISOCode
     * @param  string  $username
     * @return string
     */
    public static function generate(int $ISOCode, string $username)
    {
        $captcha = Extend::randomNumeric(config('extension.auth.captcha.length'));
        Redis::setex("captcha_{$ISOCode}_{$username}", config('extension.auth.captcha.ttl'), $captcha);

        return $captcha;
    }

    /**
     * @param  string  $ISOCode
     * @param  string  $username
     * @param  int  $captcha
     * @return bool
     */
    public static function validate(string $ISOCode, string $username, int $captcha)
    {
        return Redis::get("captcha_{$ISOCode}_{$username}") == $captcha;
    }

    /**
     * @param  int  $ISOCode
     * @param  string  $username
     */
    public static function clear(int $ISOCode, string $username)
    {
        Redis::del("captcha_{$ISOCode}_{$username}");
    }
}
