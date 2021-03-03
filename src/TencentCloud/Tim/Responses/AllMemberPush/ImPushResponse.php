<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class ImPushResponse extends TimResponse
{
    /**
     * @return string
     */
    public function getTaskId(): string
    {
        return $this->content['TaskId'];
    }
}
