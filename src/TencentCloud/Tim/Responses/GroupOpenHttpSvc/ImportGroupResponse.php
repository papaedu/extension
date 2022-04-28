<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class ImportGroupResponse extends TimResponse
{
    /**
     * @return string
     */
    public function getGroupId(): string
    {
        return $this->content['GroupId'];
    }
}
