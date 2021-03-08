<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class BatchSendMsgResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getErrorList(): array
    {
        return $this->content['ErrorList'];
    }

    /**
     * @return string
     */
    public function getMsgKey(): string
    {
        return $this->content['MsgKey'];
    }
}
