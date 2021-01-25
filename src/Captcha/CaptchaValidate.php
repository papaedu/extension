<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\Request;
use Papaedu\Extension\Captcha\Client\GeetestClient;
use Papaedu\Extension\Captcha\Client\TencentClient;
use Papaedu\Extension\Enums\CaptchaChannel;
use Papaedu\Extension\Support\Phone;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait CaptchaValidate
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $captchaChannel
     * @param  string  $type
     */
    protected function validate(Request $request, string $appName, string $captchaChannel, string $type)
    {
        $request->validate($this->getRules($captchaChannel), [
            'required' => trans('extension::status_message.400.default'),
        ], [
            'iso_code' => trans('extension::field.iso_code'),
            $this->username() => trans('extension::field.username'),
        ]);

        $this->validateRequest($request, $appName, $captchaChannel, $type);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $captchaChannel
     * @param  string  $type
     */
    protected function validateRequest(Request $request, string $appName, string $captchaChannel, string $type)
    {
        if (CaptchaChannel::GEETEST == $captchaChannel) {
            GeetestClient::validate(
                $request->only('geetest_challenge', 'geetest_validate', 'geetest_seccode'),
                $appName,
                $type
            );
        } elseif (CaptchaChannel::TENCENT == $captchaChannel) {
            TencentClient::validate(
                $appName,
                $request->input('ticket', ''),
                $request->ip()
            );
        } else {
            throw new HttpException(400, trans('extension::auth.geetest_failed'));
        }
    }

    protected function getRules(string $captchaChannel): array
    {
        $rules = $this->getRulesByCaptchaChannel($captchaChannel);
        if (true === config('extension.enable_global_phone', false)) {
            $rules['iso_code'] = ['required_with:'.$this->username()];
            $rules[$this->username()] = ['required', 'phone:iso_code,mobile'];
        } else {
            $rules[$this->username()] = ['required', 'phone:'.config('extension.locale.iso_code').',mobile'];
        }

        return $rules;
    }

    protected function getRulesByCaptchaChannel(string $captchaChannel): array
    {
        if (CaptchaChannel::GEETEST == $captchaChannel) {
            return [
                'geetest_challenge' => ['required'],
                'geetest_validate' => ['required'],
                'geetest_seccode' => ['required'],
            ];
        } elseif (CaptchaChannel::TENCENT == $captchaChannel) {
            return [
                'ticket' => ['required'],
            ];
        }

        return [];
    }

    /**
     * Get extra validator with IDD code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $validation
     * @param  string  $message
     */
    protected function extraValidator(Request $request, string $validation, string $message)
    {
        Phone::extraValidate($request, $validation, $this->username(), $this->userModel(), $this->IDDCode, $message);
    }
}
