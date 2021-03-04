<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetOnlineMemberNumResponse extends TimResponse
{
    /**
     * @return string
     */
    public function getGroupId(): string
    {
        return $this->content['GroupId'];
    }

    /**
     * @return int
     */
    public function getOnlineMemberNum(): int
    {
        return $this->content['OnlineMemberNum'];
    }
}
