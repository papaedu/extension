<?php

namespace Papaedu\Extension\Validation\Rules;

use Papaedu\Extension\Captcha\CaptchaValidator;

class AuthCaptcha
{
    /**
     * Validate captcha with IDD code and username.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array  $parameters
     * @param  object  $validator
     * @return bool
     */
    public function validate($attribute, $value, array $parameters, $validator): bool
    {
        return CaptchaValidator::validate($parameters[0], $parameters[1] ?? '', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return ':attribute错误';
    }
}
