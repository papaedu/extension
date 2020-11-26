<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Papaedu\Extension\Captcha\CaptchaValidator;
use Papaedu\Extension\Support\GlobalPhone;

trait ForgetsPasswords
{
    use AuthTrait;

    /**
     * Handle a forgot password request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgot(Request $request)
    {
        $this->validateForgot($request);

        event(new PasswordReset($guest = $this->update($request->only(['idd_code', $this->username(), 'password']))));

        $guest->tokens()->delete();

        $this->guard()->login($guest);

        return $this->sendForgotResponse($request);
    }

    /**
     * Validate the guest forgot password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateForgot(Request $request)
    {
        $request->validate(GlobalPhone::getMainValidator($this->username(), [
            $this->username() => ['required', 'phone:'.config('extension.locale.iso_code').',mobile', 'exists:'.$this->userModel().','.$this->username()],
            'password' => ['required', 'password_strength'],
            'captcha' => ['required', 'digits:'.config('extension.auth.captcha.length'), 'captcha:'.$this->username()],
        ], [
            $this->username() => [Rule::exists($this->userModel(), $this->username())->where('idd_code', $request->input('idd_code', config('extension.locale.idd_code')))],
        ]), [
            $this->username().'exists' => trans('extension::auth.unregister'),
            'captcha.digits' => trans('extension::auth.captcha_failed'),
        ], [
            'idd_code' => trans('extension::field.idd_code'),
            $this->username() => trans('extension::field.username'),
            'captcha' => trans('extension::field.captcha'),
            'password' => trans('extension::field.password'),
        ]);
    }

    /**
     * Send the response after the guest was forgot password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendForgotResponse(Request $request)
    {
        CaptchaValidator::clear($request->input('idd_code', config('extension.locale.idd_code')), $request->input($this->username()));

        $this->validateStatus($this->guard()->user()->status);

        if ($response = $this->beforeForgotResponse($request, $this->guard()->user())) {
            return $response;
        }

        return $this->tokenResponse($this->guard()->user());
    }

    /**
     * The user has been forgot password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function beforeForgotResponse(Request $request, $user)
    {

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