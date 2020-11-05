<?php

namespace Papaedu\Extension\Foundation\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Papaedu\Extension\Support\CaptchaValidator;

trait ResetsMobiles
{
    use AuthTrait;

    /**
     * Handle a reset mobile request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validateReset($request);

        $user = $this->update($this->guard()->user(), $request->new_mobile);

        $user->tokens()->delete();

        return $this->sendResetResponse($request);
    }

    /**
     * Validate the guest login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateReset(Request $request)
    {
        $request->validate([
            'password' => ['required', 'password'],
            'new_mobile' => ['required', 'mobile', 'unique:'.$this->userModel().','.$this->username()],
            'captcha' => ['required', 'digits:4', 'captcha:new_mobile'],
        ], [
            'new_mobile.unique' => trans('extension::auth.registered'),
        ], [
            'password' => trans('extension::field.password'),
            'new_mobile' => trans('extension::field.new_mobile'),
            'captcha' => trans('extension::field.captcha'),
        ]);
    }

    /**
     * Send the response after the guest was reset mobile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request)
    {
        CaptchaValidator::clear($request->new_mobile);

        if ($response = $this->beforeResetResponse($request, $this->guard()->user())) {
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