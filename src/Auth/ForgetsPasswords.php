<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Papaedu\Extension\Support\CaptchaValidator;

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

        event(new PasswordReset($guest = $this->update($request->only([$this->username(), 'password']))));

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
        $request->validate([
            $this->username() => ['required', 'mobile', 'exists:'.$this->userModel().','.$this->username()],
            'password' => ['required', 'password_strength'],
            'captcha' => ['required', 'digits:'.config('extension.auth.captcha.length'), 'captcha:mobile'],
        ], [
            'exists' => '此:attribute尚未注册',
            'captcha.digits' => ':attribute错误',
        ], [
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
        CaptchaValidator::clear($request->input($this->username()));

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