<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\OpenConfigSvr;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetIpListResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getIpList(): array
    {
        return $this->content['IPList'];
    }
}
