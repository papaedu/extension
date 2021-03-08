<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\OpenConfigSvr;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetNoSpeakingResponse extends TimResponse
{
    /**
     * @return int
     */
    public function getC2CMsgNoSpeakingTime(): int
    {
        return $this->content['C2CmsgNospeakingTime'];
    }

    /**
     * @return int
     */
    public function getGroupMsgNoSpeakingTime(): int
    {
        return $this->content['GroupmsgNospeakingTime'];
    }
}
