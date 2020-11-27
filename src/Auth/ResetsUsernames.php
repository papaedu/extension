<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Captcha\CaptchaValidator;
use Papaedu\Extension\Support\Phone;

trait ResetsUsernames
{
    use AuthTrait;

    /**
     * @var string
     */
    protected $IDDCode = '';

    /**
     * Handle a reset mobile request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validateReset($request);

        $user = $this->update($this->guard()->user(), ['idd_code' => $this->IDDCode] + $request->only('iso_code', 'new_username'));

        $user->tokens()->delete();

        return $this->sendResetResponse($request, $user);
    }

    /**
     * Validate the guest login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateReset(Request $request)
    {
        Phone::validate($request, 'new_username', [
            'password' => ['required', 'password_strength'],
            'captcha' => ['required', 'digits:'.config('extension.auth.captcha.length'), 'captcha:new_username'],
        ], [
            'captcha.digits' => trans('extension::auth.captcha_failed'),
        ], [
            'password' => trans('extension::field.password'),
            'new_username' => trans('extension::field.new_username'),
            'captcha' => trans('extension::field.captcha'),
        ]);

        $this->IDDCode = Phone::ISOCode2IDDCode($request->new_username, $request->input('iso_code', config('extension.locale.iso_code')));
        Phone::extraValidate($request, 'unique', 'new_username', $this->userModel(), $this->IDDCode, trans('extension::auth.registered'), $this->username());
    }

    /**
     * Send the response after the guest was reset mobile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request, $user)
    {
        CaptchaValidator::clear($request->input('idd_code', config('extension.locale.idd_code')), $request->new_username);

        if ($response = $this->beforeResetResponse($request, $user)) {
            return $response;
        }

        return new JsonResponse([], 204);
    }

    /**
     * The user has been reset mobile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function beforeResetResponse(Request $request, $user)
    {
        //
    }

    /**
     * Get the guard model to be used.
     *
     * @return string
     */
    public function userModel()
    {
        return 'App\User';
    }
}