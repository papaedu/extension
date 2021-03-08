<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Sns;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class BlackListGetResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getBlackListItem(): array
    {
        return $this->content['BlackListItem'];
    }

    /**
     * @return int
     */
    public function getStartIndex(): int
    {
        return $this->content['StartIndex'];
    }

    /**
     * @return int
     */
    public function getCurrentSequence(): int
    {
        return $this->content['CurrentSequence'];
    }

    /**
     * @return string
     */
    public function getErrorDisplay(): string
    {
        return $this->content['ErrorDisplay'];
    }
}
