<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Support\Phone;

trait AuthenticatesCaptcha
{
    /**
     * Send captcha for the user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, string $appName, string $clientType)
    {
        $this->validator($request, $appName, $clientType);

        $ISOCode = $request->input('iso_code', config('extension.locale.iso_code'));
        $IDDCode = Phone::ISOCode2IDDCode($request->input($this->username()), $ISOCode);
        $captcha = CaptchaValidator::generate($ISOCode, $request->username);
        CaptchaNotification::login($IDDCode, $request->username, $captcha);

        return new JsonResponse([], 204);
    }
}