<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Sns;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class FriendGetListResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getInfoItem(): array
    {
        return $this->content['InfoItem'];
    }

    /**
     * @return array
     */
    public function getFailAccount(): array
    {
        return $this->content['Fail_Account'];
    }

    /**
     * @return string
     */
    public function getErrorDisplay(): string
    {
        return $this->content['ErrorDisplay'];
    }
}
