<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GroupMsgGetSimpleResponse extends TimResponse
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
    public function getIsFinished(): int
    {
        return $this->content['IsFinished'];
    }

    /**
     * @return array
     */
    public function getRspMsgList(): array
    {
        return $this->content['RspMsgList'];
    }
}
