<?php

namespace Papaedu\Extension\Auth\Local;

use Illuminate\Http\Request;
use Papaedu\Extension\Auth\BaseForgetsPasswords;

trait ForgetsPasswords
{
    use BaseForgetsPasswords;

    /**
     * Validate the guest forgot password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateForgot(Request $request)
    {
        $request->validate(
            [
                $this->username() => ['required', 'phone:'.config('extension.locale.iso_code').',mobile'],
                'password' => ['required', 'password_strength'],
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
                'password' => trans('extension::field.password'),
            ]
        );

        $request->validate(
            [
                $this->username() => ["exists:{$this->userModel()}.{$this->username()}"],
            ],
            [
                $this->username().'.exists' => trans('extension::auth.unregister'),
            ],
            [
                $this->username() => trans('extension::field.username'),
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
}
