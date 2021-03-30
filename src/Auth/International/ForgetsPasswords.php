<?php

namespace Papaedu\Extension\Auth\International;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Papaedu\Extension\Auth\BaseForgetsPasswords;
use Papaedu\Extension\Support\Phone;

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
                'iso_code' => ['required_with:'.$this->username()],
                $this->username() => ['required', 'phone:iso_code,mobile'],
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
                'iso_code' => trans('extension::field.iso_code'),
                $this->username() => trans('extension::field.username'),
                'captcha' => trans('extension::field.captcha'),
                'password' => trans('extension::field.password'),
            ]
        );
        $this->IDDCode = Phone::ISOCode2IDDCode(
            $request->input($this->username()),
            $request->input('iso_code', config('extension.locale.iso_code'))
        );
        $request->validate(
            [
                $this->username() => [
                    Rule::exists($this->userModel(), $this->username())->where('idd_code', $this->IDDCode),
                ],
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
        return ['idd_code' => $this->IDDCode];
    }
}
