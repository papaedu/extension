<?php

namespace Papaedu\Extension\Validation\Rules;

use Papaedu\Extension\Captcha\CaptchaValidator;

class AuthCaptcha
{
    /**
     * Validate captcha with IDD code and username.
     */
    public function validate($attribute, $value, array $parameters, $validator): bool
    {
        return app(CaptchaValidator::class)->validate($parameters[0], $parameters[1] ?? '', $value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return ':attribute错误';
    }
}
