<?php

namespace Papaedu\Extension\Exceptions;

use Exception as BaseException;

class Exception extends BaseException
{
    public function toArray(): array
    {
        return [
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
        ];
    }
}
