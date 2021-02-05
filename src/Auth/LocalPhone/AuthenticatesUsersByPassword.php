<?php

namespace Papaedu\Extension\Auth\LocalPhone;

use Illuminate\Http\Request;
use Papaedu\Extension\Auth\BaseAuthenticatesUsersByPassword;

trait AuthenticatesUsersByPassword
{
    use BaseAuthenticatesUsersByPassword;

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
                'password' => ['required', 'string', 'min:8'],
            ],
            [
                'password.min' => trans('extension::auth.failed'),
            ],
            [
                $this->username() => trans('extension::field.username'),
                'password' => trans('extension::field.password'),
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
