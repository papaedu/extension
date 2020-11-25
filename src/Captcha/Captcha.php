<?php

namespace Papaedu\Extension\Captcha;

trait Captcha
{
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
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