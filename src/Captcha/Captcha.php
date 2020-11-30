<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\Request;
use Papaedu\Extension\Support\GeetestClient;
use Papaedu\Extension\Support\Phone;

trait Captcha
{
    /**
     * Validator base parameters for send captcha sms.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     */
    protected function validator(Request $request, string $appName, string $clientType)
    {
        $request->validate($this->getRules(), [
            'required' => trans('extension::validator.param_abnormal'),
        ], [
            'iso_code' => trans('extension::field.iso_code'),
            $this->username() => trans('extension::field.username'),
        ]);

        GeetestClient::validate($request->only('geetest_challenge', 'geetest_validate', 'geetest_seccode'), $appName, $clientType);
    }

    /**
     * Get rules for validator.
     *
     * @return array
     */
    protected function getRules()
    {
        $rules = [
            'geetest_challenge' => ['required'],
            'geetest_validate' => ['required'],
            'geetest_seccode' => ['required'],
        ];
        if (true === config('extension.enable_global_phone', false)) {
            $rules['iso_code'] = ['required_with:'.$this->username()];
            $rules[$this->username()] = ['required', 'phone:iso_code,mobile'];
        } else {
            $rules[$this->username()] = ['required', 'phone:'.config('extension.locale.iso_code').',mobile'];
        }

        return $rules;
    }

    /**
     * Get extra validator with IDD code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $validation
     * @param  string  $IDDCode
     * @param  string  $message
     */
    protected function extraValidator(Request $request, string $validation, string $IDDCode, string $message)
    {
        Phone::extraValidate($request, $validation, $this->username(), $this->userModel(), $IDDCode, $message);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * Get the guard model to be used.
     *
     * @return string
     */
    protected function userModel()
    {
        return 'App\User';
    }
}