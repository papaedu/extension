<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Sns;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class FriendDeleteAllResponse extends TimResponse
{
    /**
     * @return string
     */
    public function getErrorDisplay(): string
    {
        return $this->content['ErrorDisplay'];
    }
}
