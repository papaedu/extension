<?php

namespace Papaedu\Extension\Captcha;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Papaedu\Extension\Support\GeetestClient;
use Papaedu\Extension\Support\GlobalPhone;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ResetCaptcha
{
    /**
     * Send captcha for the user reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request, string $appName, string $clientType)
    {
        $this->validateReset($request, $appName, $clientType);

        $captcha = CaptchaValidator::generate($request->idd_code, $request->username);
        CaptchaNotification::reset($request->idd_code, $request->username, $captcha);

        return new JsonResponse([], 204);
    }

    /**
     * Validate send captcha for the user reset password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $appName
     * @param  string  $clientType
     * @return void
     */
    protected function validateReset(Request $request, string $appName, string $clientType)
    {
        $request->validate(GlobalPhone::getValidator($this->username(), [
            'geetest_challenge' => ['required'],
            'geetest_validate' => ['required'],
            'geetest_seccode' => ['required'],
            $this->username() => ['required', 'phone:'.config('extension.locale.iso_code').',mobile', 'unique:'.$this->userModel().','.$this->username()],
        ], [
            $this->username() => [Rule::unique($this->userModel(), $this->username())->where('idd_code', $request->input('idd_code', config('extension.locale.idd_code')))],
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