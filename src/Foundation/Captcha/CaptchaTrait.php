<?php

namespace Papaedu\Extension\Foundation\Captcha;

use Symfony\Component\HttpKernel\Exception\HttpException;

trait CaptchaTrait
{
    /**
     * @param  string  $appName
     * @param  string  $clientType
     */
    protected function validateParams(string $appName, string $clientType)
    {
        if (!$this->validateGeetest($appName, $clientType)) {
            throw new HttpException(400, trans('extension::auth.geetest_failed'));
        }
    }
}