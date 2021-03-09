<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class AdminGetRoamMsgResponse extends TimResponse
{
    /**
     * @return int
     */
    public function getComplete(): int
    {
        return $this->content['Complete'];
    }

    /**
     * @return int
     */
    public function getMsgCnt(): int
    {
        return $this->content['MsgCnt'];
    }

    /**
     * @return int
     */
    public function getLastMsgTime(): int
    {
        return $this->content['LastMsgTime'];
    }

    /**
     * @return string
     */
    public function getLastMsgKey(): string
    {
        return $this->content['LastMsgKey'];
    }

    /**
     * @return array
     */
    public function getMsgList(): array
    {
        return $this->content['MsgList'];
    }
}
