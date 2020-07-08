<?php

namespace Papaedu\Extension\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class MultipleOf implements Rule
{
    private $parameters;

    /**
     * Create a new rule instance.
     *
     * @param  array  $parameters
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
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
        if (!is_numeric($value)) {
            return false;
        }

        return $value % Arr::first($this->parameters) == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $value = Arr::first($this->parameters);

        return ":attribute必须为{$value}的倍数";
    }
}
