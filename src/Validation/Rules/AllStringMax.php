<?php

namespace Papaedu\Extension\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class AllStringMax implements Rule
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
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $max = Arr::first($this->parameters);

        return mb_strlen($value, 'gb2312') <= $max;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $max = Arr::first($this->parameters);

        return ":attribute不能超过{$max}个字符";
    }
}
