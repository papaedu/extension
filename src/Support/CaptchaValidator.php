<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Facades\Redis;

class CaptchaValidator
{
    /**
     * @param  string  $mobile
     * @return string
     */
    public static function generate(string $mobile)
    {
        $captcha = Extend::randomNumeric(config('extension::auth.captcha.length'));
        Redis::setex("captcha_{$mobile}", config('extension::auth.captcha.ttl'), $captcha);

        return $captcha;
    }

    /**
     * @param  string  $mobile
     * @param  int  $captcha
     * @return bool
     */
    public static function validate(string $mobile, int $captcha)
    {
        return Redis::get("captcha_{$mobile}") == $captcha;
    }

    /**
     * @param  string  $mobile
     */
    public static function clear(string $mobile)
    {
        Redis::del("captcha_{$mobile}");
    }
}
