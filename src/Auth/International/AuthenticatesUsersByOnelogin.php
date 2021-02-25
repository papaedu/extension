<?php

namespace Papaedu\Extension\Auth\International;

use Papaedu\Extension\Auth\BaseAuthenticatesUsersByOnelogin;

trait AuthenticatesUsersByOnelogin
{
    use BaseAuthenticatesUsersByOnelogin;

    /**
     * @return array
     */
    protected function extraParams(): array
    {
        return [
            'idd_code' => config('extension.locale.idd_code'),
            'iso_code' => config('extension.locale.iso_code'),
        ];
    }
}
