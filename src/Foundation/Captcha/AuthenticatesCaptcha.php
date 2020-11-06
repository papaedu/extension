<?php

namespace Papaedu\Extension\Foundation\Captcha;

use App\Http\Requests\Auth\CaptchaLoginRequest;
use Papaedu\Extension\Support\CaptchaNotification;
use Papaedu\Extension\Support\CaptchaValidator;
use Papaedu\Extension\Traits\GeetestTrait;

trait AuthenticatesCaptcha
{
    use GeetestTrait;

    /**
     * 登录验证码
     *
     * @param  \App\Http\Requests\Auth\CaptchaLoginRequest  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return \Illuminate\Http\Response
     */
    public function login(CaptchaLoginRequest $request, string $appName, string $clientType)
    {
        $this->validateParams($appName, $clientType);

        $captcha = CaptchaValidator::generate($request->mobile);
        CaptchaNotification::login($request->mobile, $captcha);

        return $this->response->noContent();
    }
}