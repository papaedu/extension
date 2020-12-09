<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait ResetsPasswords
{
    use AuthTrait;

    /**
     * Handle a reset password request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $this->validateReset($request);

        event(new PasswordReset($user = $this->update($this->guard()->user(), $request->new_password)));

        $user->tokens()->delete();

        return $this->sendResetResponse($request);
    }

    /**
     * Validate the user reset password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateReset(Request $request)
    {
        $request->validate([
            'password' => ['required', 'password'],
            'new_password' => ['required', 'password_strength'],
        ], [], [
            'password' => trans('extension::field.old_password'),
            'new_password' => trans('extension::field.new_password'),
        ]);
    }

    /**
     * Send the response after the user was reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResetResponse(Request $request)
    {
        if ($response = $this->beforeResetResponse($request, $this->guard()->user())) {
            return $response;
        }

        return new JsonResponse(null, 204);
    }

    /**
     * The user has been reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function beforeResetResponse(Request $request, $user)
    {
        //
    }
}
