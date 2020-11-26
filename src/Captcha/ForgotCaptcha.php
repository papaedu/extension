<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait ForgotCaptcha
{
    /**
     * Send captcha for the user forgot password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgot(Request $request, string $appName, string $clientType)
    {
        $this->validator($request, $appName, $clientType);

        $IDDCode = $this->ISOCode2IDDCode($request->input($this->username()), $request->input('iso_code', config('extension.locale.iso_code')));
        $this->extraValidator('exists', $IDDCode);

        $captcha = CaptchaValidator::generate($IDDCode, $request->username);
        CaptchaNotification::forgot($IDDCode, $request->username, $captcha);

        return new JsonResponse([], 204);
    }
}