<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Sns;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class BlackListCheckResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getBlackListCheckItem(): array
    {
        return $this->content['BlackListCheckItem'];
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
