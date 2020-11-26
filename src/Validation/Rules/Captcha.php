<?php

namespace Papaedu\Extension\Validation\Rules;

use Papaedu\Extension\Captcha\CaptchaValidator;

class Captcha
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
    public function validate($attribute, $value, array $parameters, $validator)
    {
        $data = $validator->getData();

        $iddCode = $data['idd_code'] ?? config('extension.locale.idd_code');
        if (!$username = $data[$parameters[0]] ?? '') {
            return false;
        }

        return CaptchaValidator::validate($iddCode, $username, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute错误';
    }
}
