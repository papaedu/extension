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

        $ISOCode = $request->input('iso_code', config('extension.locale.iso_code'));
        $IDDCode = Phone::ISOCode2IDDCode($request->input($this->username()), $ISOCode);
        $this->extraValidator($request, 'unique', $IDDCode, trans('extension::auth.registered'));

        $captcha = CaptchaValidator::generate($ISOCode, $request->username);
        CaptchaNotification::register($request->username, $IDDCode, $captcha);

        return new JsonResponse([], 204);
    }
}
