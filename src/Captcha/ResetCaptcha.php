<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait ResetCaptcha
{
    /**
     * Send captcha for the user reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request, string $appName, string $clientType)
    {
        $this->validator($request, $appName, $clientType);

        $IDDCode = $this->ISOCode2IDDCode($request->input($this->username()), $request->input('iso_code', config('extension.locale.iso_code')));
        $this->extraValidator('unique', $IDDCode);

        $captcha = CaptchaValidator::generate($IDDCode, $request->username);
        CaptchaNotification::reset($IDDCode, $request->username, $captcha);

        return new JsonResponse([], 204);
    }
}