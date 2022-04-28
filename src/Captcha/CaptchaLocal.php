<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\Request;

trait CaptchaLocal
{
    use BaseCaptcha;

    protected function validateCaptcha(Request $request)
    {
        $request->validate([
            'geetest_challenge' => ['required'],
            'geetest_validate' => ['required'],
            'geetest_seccode' => ['required'],
            $this->username() => ['required', 'phone:'.config('extension.locale.iso_code').',mobile'],
        ], [
            'required' => trans('extension::status_message.400.default'),
        ], [
            $this->username() => trans('extension::field.username'),
        ]);
    }
}
