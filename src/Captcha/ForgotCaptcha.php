<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Support\Phone;

trait ForgotCaptcha
{
    /**
     * Send captcha for the user forgot password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $geetestClientType
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgot(Request $request, string $appName, string $geetestClientType)
    {
        $this->validator($request, $appName, $geetestClientType);

        $ISOCode = $request->input('iso_code', config('extension.locale.iso_code'));
        $IDDCode = Phone::ISOCode2IDDCode($request->input($this->username()), $ISOCode);
        $this->extraValidator($request, 'exists', $IDDCode, trans('extension::auth.unregister'));

        $captcha = CaptchaValidator::generate($ISOCode, $request->username);
        CaptchaNotification::forgot($request->username, $IDDCode, $captcha);

        return new JsonResponse([], 204);
    }
}
