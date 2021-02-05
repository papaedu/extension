<?php

namespace Papaedu\Extension\Auth\LocalPhone;

use Papaedu\Extension\Auth\BaseAuthenticatesUsersByOnelogin;

trait AuthenticatesUsersByOnelogin
{
    use BaseAuthenticatesUsersByOnelogin;

    /**
     * @return array
     */
    protected function extraParams(): array
    {
        return [];
    }
}
