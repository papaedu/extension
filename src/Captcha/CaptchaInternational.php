<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\Request;

trait CaptchaInternational
{
    use BaseCaptcha;

    protected function validateCaptcha(Request $request): void
    {
        $request->validate([
            'geetest_challenge' => ['required'],
            'geetest_validate' => ['required'],
            'geetest_seccode' => ['required'],
            'iso_code' => ['required_with:'.$this->username()],
            $this->username() => ['required', 'phone:iso_code,mobile'],
        ], [
            'required' => trans('extension::status_message.400.default'),
        ], [
            'iso_code' => trans('extension::field.iso_code'),
            $this->username() => trans('extension::field.username'),
        ]);
    }
}
