<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Papaedu\Extension\Captcha\CaptchaValidator;
use Papaedu\Extension\Support\Phone;

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

        event(new Registered($user = $this->create($request->only(['idd_code', $this->username(), 'password']))));

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
        Phone::validate($request, $this->username(), [
            'password' => ['required', 'password_strength'],
            'captcha' => ['required', 'digits:'.config('extension.auth.captcha.length'), 'captcha:'.$this->username()],
        ], [
            'captcha.digits' => trans('extension::auth.captcha_failed'),
        ], [
            'captcha' => trans('extension::field.captcha'),
            'password' => trans('extension::field.password'),
        ]);
//        $this->username() => ['required', 'phone:'.config('extension.locale.iso_code').',mobile', 'unique:'.$this->userModel().','.$this->username()],
//        $this->username() => [Rule::unique($this->userModel(), $this->username())->where('idd_code', $request->input('idd_code', config('extension.locale.idd_code')))],
//        $this->username().'.unique' => trans('extension::auth.registered'),
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
        CaptchaValidator::clear($request->input('idd_code', config('extension.locale.idd_code')), $request->input($this->username()));

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