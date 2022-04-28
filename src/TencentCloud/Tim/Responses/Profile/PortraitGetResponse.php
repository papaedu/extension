<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Profile;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class PortraitGetResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getUserProfileItem(): array
    {
        return $this->content['UserProfileItem'];
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
