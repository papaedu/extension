<?php

namespace Papaedu\Extension\Auth\International;

use Illuminate\Http\Request;
use Papaedu\Extension\Auth\BaseAuthenticatesUsersByPassword;
use Papaedu\Extension\Support\Phone;

trait AuthenticatesUsersByPassword
{
    use BaseAuthenticatesUsersByPassword;

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
                'password' => ['required', 'string', 'between:8,16'],
            ],
            [
                'password.between' => trans('extension::auth.failed'),
            ],
            [
                'iso_code' => trans('extension::field.iso_code'),
                $this->username() => trans('extension::field.username'),
                'password' => trans('extension::field.password'),
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
        return ['idd_code' => $this->IDDCode];
    }
}
