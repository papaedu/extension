<?php

namespace Papaedu\Extension\Auth\International;

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
                'iso_code' => ['required_with:new_username'],
                'new_username' => ['required', 'phone:iso_code,mobile'],
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
                'iso_code' => trans('extension::field.iso_code'),
                'new_username' => trans('extension::field.new_username'),
                'captcha' => trans('extension::field.captcha'),
            ]
        );
        $this->IDDCode = Phone::ISOCode2IDDCode(
            $request->new_username,
            $request->input('iso_code', config('extension.locale.iso_code'))
        );
        $request->validate(
            [
                'new_username' => [
                    Rule::unique($this->userModel(), $this->username())->where('idd_code', $this->IDDCode),
                ],
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
