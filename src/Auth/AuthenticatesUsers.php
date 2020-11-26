<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Papaedu\Extension\Support\GlobalPhone;

trait AuthenticatesUsers
{
    use AuthTrait;
    use ThrottlesLogins;

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
        $request->validate(GlobalPhone::getMainValidator($this->username(), [
            $this->username() => ['required', 'phone:'.config('extension.locale.iso_code').',mobile'],
            'password' => ['required', 'string', 'min:8'],
        ]), [
            'password.min' => trans('extension::auth.failed'),
        ], [
            'idd_code' => trans('extension::field.idd_code'),
            $this->username() => trans('extension::field.username'),
            'password' => trans('extension::field.password'),
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt($this->credentials($request));
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('idd_code', $this->username(), 'password');
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
            $this->username() => [trans('extension::auth.failed')],
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->user()->currentAccessToken()->delete();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return new JsonResponse('', 204);
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }
}