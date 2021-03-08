<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Profile;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class PortraitSetResponse extends TimResponse
{
    /**
     * @return string
     */
    public function getErrorDisplay(): string
    {
        return $this->content['ErrorDisplay'];
    }
}
