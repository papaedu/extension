<?php

namespace Papaedu\Extension\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;
use Papaedu\Extension\Support\CaptchaValidator;

class Captcha implements ImplicitRule
{
    private $parameters;

    private $validator;

    /**
     * Create a new rule instance.
     *
     * @param  array  $parameters
     * @param  \Illuminate\Validation\Validator  $validator
     */
    public function __construct($parameters, $validator)
    {
        $this->parameters = $parameters;
        $this->validator = $validator;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  string|int  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$mobile = $this->validator->getData()[$this->parameters[0] ?? 'username'] ?? '') {
            return false;
        }

        return CaptchaValidator::validate($mobile, $value);
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
