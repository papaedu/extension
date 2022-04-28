<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Sns;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GroupDeleteResponse extends TimResponse
{
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
