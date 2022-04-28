<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class SendMsgResponse extends TimResponse
{
    /**
     * @return int
     */
    public function getMsgTime(): int
    {
        return $this->content['MsgTime'];
    }

    /**
     * @return string
     */
    public function getMsgKey(): string
    {
        return $this->content['MsgKey'];
    }
}
