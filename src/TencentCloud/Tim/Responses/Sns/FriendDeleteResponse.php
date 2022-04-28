<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Sns;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class FriendDeleteResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getResultItem(): array
    {
        return $this->content['ResultItem'];
    }

    /**
     * @return string
     */
    public function getErrorDisplay(): string
    {
        return $this->content['ErrorDisplay'];
    }
}
