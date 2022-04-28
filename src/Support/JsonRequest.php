<?php

namespace Papaedu\Extension\Support;

use Illuminate\Http\Request;

class JsonRequest extends Request
{
    /**
     * @return bool
     */
    public function expectsJson(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function wantsJson(): bool
    {
        return true;
    }
}
