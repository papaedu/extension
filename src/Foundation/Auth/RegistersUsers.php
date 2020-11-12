<?php

namespace Papaedu\Extension\Foundation\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Papaedu\Extension\Support\CaptchaValidator;

trait RegistersUsers
{
    use AuthTrait;

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validateRegister($request);

        event(new Registered($user = $this->create($request->only([$this->username(), 'password']))));

        $this->guard()->login($user);

        return $this->sendRegisterResponse($request, $user);
    }

    /**
     * Validate the guest register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateRegister(Request $request)
    {
        $request->validate([
            $this->username() => ['required', 'mobile', 'unique:'.$this->userModel().','.$this->username()],
            'password' => ['required', 'between:8,16', 'password_strength'],
            'captcha' => ['required', 'digits:'.config('extension.auth.captcha.length'), 'captcha:'.$this->username()],
        ], [
            $this->username().'.unique' => trans('extension::auth.registered'),
            'captcha.digits' => trans('extension::auth.captcha_failed'),
        ], [
            $this->username() => trans('extension::field.username'),
            'password' => trans('extension::field.password'),
            'captcha' => trans('extension::field.captcha'),
        ]);
    }

    /**
     * Send the response after the user was registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendRegisterResponse(Request $request, $user)
    {
        CaptchaValidator::clear($request->input($this->username()));

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $this->tokenResponse($user);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
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