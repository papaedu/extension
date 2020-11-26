<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Support\Phone;

trait RegisterCaptcha
{
    /**
     * Send captcha for the user register.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, string $appName, string $clientType)
    {
        $this->validator($request, $appName, $clientType);

        $IDDCode = Phone::ISOCode2IDDCode($request->input($this->username()), $request->input('iso_code', config('extension.locale.iso_code')));
        $this->extraValidator($request, 'unique', $IDDCode, trans('extension::auth.registered'));

        $captcha = CaptchaValidator::generate($IDDCode, $request->username);
        CaptchaNotification::register($IDDCode, $request->username, $captcha);

        return new JsonResponse([], 204);
    }
}