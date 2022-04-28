<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class SendGroupMsgResponse extends TimResponse
{
    /**
     * @return int
     */
    public function getMsgTime(): int
    {
        return $this->content['MsgTime'];
    }

    /**
     * @return int
     */
    public function getMsgSeq(): int
    {
        return $this->content['MsgSeq'];
    }
}
