<?php

namespace Papaedu\Extension\Auth\Local;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Papaedu\Extension\Auth\BaseResetsUsernames;
use Papaedu\Extension\Support\Phone;

trait ResetsUsernames
{
    use BaseResetsUsernames;

    /**
     * Validate the guest login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateReset(Request $request)
    {
        $request->validate(
            [
                'password' => ['required', 'password'],
                'new_username' => ['required', 'phone:'.config('extension.locale.iso_code').',mobile'],
                'captcha' => [
                    'required',
                    'digits:'.config('extension.auth.captcha.length'),
                    'captcha:new_username',
                ],
            ],
            [
                'captcha.digits' => trans('extension::auth.captcha_failed'),
            ],
            [
                'password' => trans('extension::field.password'),
                'new_username' => trans('extension::field.new_username'),
                'captcha' => trans('extension::field.captcha'),
            ]
        );

        $request->validate(
            [
                'new_username' => ["unique:{$this->userModel()}.{$this->username()}"],
            ],
            [
                'new_username.unique' => trans('extension::auth.registered'),
            ],
            [
                'new_username' => trans('extension::field.username'),
            ]
        );
    }
}
