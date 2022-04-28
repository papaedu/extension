<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetGroupShuttedUinResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getShuttedUinList(): array
    {
        return $this->content['ShuttedUinList'];
    }
}
