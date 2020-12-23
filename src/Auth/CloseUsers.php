<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Papaedu\Extension\Models\CloseUser;
use Papaedu\Extension\Support\Phone;

trait CloseUsers
{
    use AuthTrait;

    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function close(Request $request)
    {
        // $this->validateClosed($request);

        $this->guard()->user()->socialites()->delete();
        $this->guard()->user()->tokens()->delete();

        $this->closed($this->guard()->user());
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     */
    public function validateClosed(Request $request)
    {
        Phone::validate($request, $this->username(), [
            'captcha' => [
                'required',
                'digits:'.config('extension.auth.captcha.length'),
                'captcha:'.$this->username(),
            ],
        ], [
            'captcha.digits' => trans('extension::auth.captcha_failed'),
        ], [
            'captcha' => trans('extension::field.captcha'),
        ]);
    }

    /**
     * @param  mixed  $user
     */
    protected function closed($user)
    {
        DB::transaction(function () use ($user) {
            CloseUser::create($user->toArray() + [
                    $this->userId() => $user->id,
                    'registered_at' => $user->created_at,
                ]);
            $user->delete();
        });
    }

    /**
     * @return string
     */
    protected function userId(): string
    {
        return 'user_id';
    }
}
