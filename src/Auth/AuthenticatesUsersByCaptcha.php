<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Papaedu\Extension\Captcha\CaptchaValidator;
use Papaedu\Extension\Support\Phone;

trait AuthenticatesUsersByCaptcha
{
    use AuthTrait;
    use ThrottlesLogins;

    /**
     * @var string
     */
    protected $IDDCode = '';

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        $this->sendFailedLoginResponse();
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        Phone::validate($request, $this->username(), [
            'captcha' => ['required', 'digits:'.config('extension.auth.captcha.length'), 'captcha:'.$this->username()],
        ], [
            'captcha.digits' => trans('extension::auth.captcha_failed'),
        ], [
            'captcha' => trans('extension::field.captcha'),
        ]);

        $this->IDDCode = Phone::ISOCode2IDDCode($request->input($this->username()), $request->input('iso_code', config('extension.locale.iso_code')));
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $user = $this->create(['idd_code' => $this->IDDCode] + $request->only('iso_code', $this->username()));
        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        $this->guard()->login($user);

        return true;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        CaptchaValidator::clear($request->input('idd_code', config('extension.locale.idd_code')), $request->input($this->username()));

        $this->validateStatus($this->guard()->user()->status);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $this->tokenResponse($this->guard()->user());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse()
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('extension::auth.captcha_failed')],
        ]);
    }
}