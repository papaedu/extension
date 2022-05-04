<?php

namespace Papaedu\Extension\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class HtmlSpecialChars extends TransformsRequest
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    protected function transform($key, $value)
    {
        if (in_array($key, $this->except, true)) {
            return $value;
        }

        return is_string($value) ? htmlspecialchars($value) : $value;
    }
}
