<?php

namespace Papaedu\Extension\Auth\International;

use Illuminate\Http\Request;
use Papaedu\Extension\Auth\BaseAuthenticatesUsersByCaptcha;
use Papaedu\Extension\Captcha\CaptchaValidator;
use Papaedu\Extension\Support\Phone;

trait AuthenticatesUsersByCaptcha
{
    use BaseAuthenticatesUsersByCaptcha;

    /**
     * @var int|null
     */
    protected ?int $IDDCode = null;

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
                'iso_code' => ['required_with:'.$this->username()],
                $this->username() => ['required', 'phone:iso_code,mobile'],
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
            ]
        );

        $this->IDDCode = Phone::ISOCode2IDDCode(
            $request->input($this->username()),
            $request->input('iso_code', config('extension.locale.iso_code'))
        );
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function extraParams(Request $request): array
    {
        return [
            'idd_code' => $this->IDDCode,
            'iso_code' => $request->input('iso_code', config('extension.locale.iso_code')),
        ];
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
