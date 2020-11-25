<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Support\CaptchaNotification;
use Papaedu\Extension\Support\CaptchaValidator;
use Papaedu\Extension\Support\GeetestClient;
use Papaedu\Extension\Support\GlobalPhone;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait AuthenticatesCaptcha
{
    /**
     * Send captcha for the user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request, string $appName, string $clientType)
    {
        $this->validateLogin($request, $appName, $clientType);

        $captcha = CaptchaValidator::generate($request->idd_code, $request->username);
        CaptchaNotification::login($request->idd_code, $request->username, $captcha);

        return new JsonResponse([], 204);
    }

    /**
     * Validate send captcha for the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return void
     */
    protected function validateLogin(Request $request, string $appName, string $clientType)
    {
        $request->validate(GlobalPhone::getValidator($this->username(), [
            'geetest_challenge' => ['required'],
            'geetest_validate' => ['required'],
            'geetest_seccode' => ['required'],
            $this->username() => ['required', 'phone:'.config('extension.locale.iso_code').',mobile'],
        ]), [
            'required' => trans('extension::validator.param_abnormal'),
        ], [
            'idd_code' => trans('extension::field.idd_code'),
            $this->username() => trans('extension::field.username'),
        ]);

        if (!GeetestClient::validate($appName, $clientType)) {
            throw new HttpException(400, trans('extension::auth.geetest_failed'));
        }
    }
}