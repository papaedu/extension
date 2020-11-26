<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Papaedu\Extension\Support\GeetestClient;
use Propaganistas\LaravelPhone\PhoneNumber;

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
        if (true === config('extension.enable_global_phone')) {
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
     * @param  string  $rule
     * @param  string  $IDDCode
     * @return array
     */
    protected function extraValidator(string $rule, string $IDDCode)
    {
        if (true === config('extension.enable_global_phone')) {
            return [$this->username() => Rule::$rule($this->userModel(), $this->username())->where('idd_code', $IDDCode)];
        } else {
            return [$this->username() => "{$rule}:".$this->userModel().','.$this->username()];
        }
    }

    /**
     * Exchange ISO code to IDD code.
     *
     * @param  string  $phoneNumber
     * @param  string  $ISOCode
     * @return int|null
     */
    protected function ISOCode2IDDCode(string $phoneNumber, string $ISOCode)
    {
        $phoneNumber = PhoneNumber::make($phoneNumber, $ISOCode);

        return $phoneNumber->getPhoneNumberInstance()->getCountryCode();
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