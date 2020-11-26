<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Support\Facades\Redis;
use Papaedu\Extension\Support\Extend;

class CaptchaValidator
{
    /**
     * @param  int  $IDDCode
     * @param  string  $mobile
     * @return string
     */
    public static function generate(int $IDDCode, string $mobile)
    {
        $captcha = Extend::randomNumeric(config('extension.auth.captcha.length'));
        Redis::setex("captcha_{$IDDCode}_{$mobile}", config('extension.auth.captcha.ttl'), $captcha);

        return $captcha;
    }

    /**
     * @param  int  $IDDCode
     * @param  string  $mobile
     * @param  int  $captcha
     * @return bool
     */
    public static function validate(int $IDDCode, string $mobile, int $captcha)
    {
        return Redis::get("captcha_{$IDDCode}_{$mobile}") == $captcha;
    }

    /**
     * @param  int  $IDDCode
     * @param  string  $mobile
     */
    public static function clear(int $IDDCode, string $mobile)
    {
        Redis::del("captcha_{$IDDCode}_{$mobile}");
    }
}
