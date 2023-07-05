<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Support\Facades\Redis;
use Papaedu\Extension\Support\Extend;

class CaptchaValidator
{
    public function generate(string $username, string $ISOCode): string
    {
        $captcha = Extend::randomNumeric(config('extension.auth.captcha.length'));
        Redis::setex($this->getKey($username, $ISOCode), config('extension.auth.captcha.ttl'), $captcha);

        return $captcha;
    }

    public function validate(string $username, string $ISOCode, string $captcha): bool
    {
        return Redis::get($this->getKey($username, $ISOCode)) == $captcha;
    }

    public function clean(string $username, string $ISOCode): void
    {
        Redis::del($this->getKey($username, $ISOCode));
    }

    public function createPassToken(string $username, string $ISOCode): void
    {
        Redis::setex(static::getTokenKey($username, $ISOCode), config('extension.auth.captcha.ttl'), 1);
    }

    public function checkPassToken(string $username, string $ISOCode): bool
    {
        return Redis::exists(static::getTokenKey($username, $ISOCode));
    }

    public function cleanPassToken(string $username, string $ISOCode): void
    {
        Redis::del(static::getTokenKey($username, $ISOCode));
    }

    protected function getKey(string $username, string $ISOCode): string
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
