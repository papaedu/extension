<?php

namespace Papaedu\Extension\Validation\Rules;

use Illuminate\Contracts\Validation\ImplicitRule;

class RequiredMultiIf implements ImplicitRule
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
    public function passes($attribute, $value): bool
    {
        if ($value) {
            return true;
        }

        $data = $this->validator->getData();
        foreach ($this->parameters as $parameter) {
            $parameter = explode('-', $parameter);
            if ($data[$parameter[0]] != $parameter[1]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return ':attribute不能为空';
    }
}
