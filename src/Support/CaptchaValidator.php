<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Facades\Redis;

class CaptchaValidator
{
    /**
     * @param  int  $iddCode
     * @param  string  $mobile
     * @return string
     */
    public static function generate(int $iddCode, string $mobile)
    {
        $captcha = Extend::randomNumeric(config('extension.auth.captcha.length'));
        Redis::setex("captcha_{$iddCode}_{$mobile}", config('extension.auth.captcha.ttl'), $captcha);

        return $captcha;
    }

    /**
     * @param  int  $iddCode
     * @param  string  $mobile
     * @param  int  $captcha
     * @return bool
     */
    public static function validate(int $iddCode, string $mobile, int $captcha)
    {
        return Redis::get("captcha_{$iddCode}_{$mobile}") == $captcha;
    }

    /**
     * @param  int  $iddCode
     * @param  string  $mobile
     */
    public static function clear(int $iddCode, string $mobile)
    {
        Redis::del("captcha_{$iddCode}_{$mobile}");
    }
}
