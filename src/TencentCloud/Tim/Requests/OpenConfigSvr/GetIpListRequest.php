<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenConfigSvr;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetIpListRequest extends TimRequest
{
    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/ConfigSvc/GetIPList';
    }
}
