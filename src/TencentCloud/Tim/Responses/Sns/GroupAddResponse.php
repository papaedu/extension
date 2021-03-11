<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\Sns;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GroupAddResponse extends TimResponse
{
    public function getResultItem(): array
    {
        return $this->content['ResultItem'];
    }

    public function getFailAccount(): array
    {
        return $this->content['Fail_Account'];
    }

    public function getCurrentSequence(): int
    {
        return $this->content['CurrentSequence'];
    }

    public function getErrorDisplay(): string
    {
        return $this->content['ErrorDisplay'];
    }
}
