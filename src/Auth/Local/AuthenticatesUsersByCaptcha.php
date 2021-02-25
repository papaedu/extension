<?php

namespace Papaedu\Extension\Auth\Local;

use Illuminate\Http\Request;
use Papaedu\Extension\Auth\BaseAuthenticatesUsersByCaptcha;
use Papaedu\Extension\Captcha\CaptchaValidator;

trait AuthenticatesUsersByCaptcha
{
    use BaseAuthenticatesUsersByCaptcha;

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username() => ['required', 'phone:'.config('extension.locale.iso_code').',mobile'],
                'captcha' => [
                    'required',
                    'digits:'.config('extension.auth.captcha.length'),
                    'captcha:'.$this->username(),
                ],
            ],
            [
                'captcha.digits' => trans('extension::auth.captcha_failed'),
            ],
            [
                $this->username() => trans('extension::field.username'),
                'captcha' => trans('extension::field.captcha'),
            ]
        );
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function extraParams(Request $request): array
    {
        return [];
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     */
    protected function clearByMethod(Request $request)
    {
        CaptchaValidator::clear(
            $request->input('idd_code', config('extension.locale.idd_code')),
            $request->input($this->username())
        );
    }
}
