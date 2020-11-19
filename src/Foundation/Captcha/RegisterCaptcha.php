<?php

namespace Papaedu\Extension\Foundation\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Support\CaptchaNotification;
use Papaedu\Extension\Support\CaptchaValidator;

trait RegisterCaptcha
{
    /**
     * Send captcha for the user register.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request, string $appName, string $clientType)
    {
        $this->validateRegister($request);
        $this->validateParams($appName, $clientType);

        $captcha = CaptchaValidator::generate($request->mobile);
        CaptchaNotification::register($request->mobile, $captcha);

        return new JsonResponse([], 204);
    }

    /**
     * Validate send captcha for the user register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateRegister(Request $request)
    {
        $request->validate([
            'geetest_challenge' => ['required'],
            'geetest_validate' => ['required'],
            'geetest_seccode' => ['required'],
            'mobile' => ['required', 'mobile'],
        ], [
            'required' => trans('extension::validator.param_abnormal'),
        ]);
    }
}