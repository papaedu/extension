<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GroupMsgRecallResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getRecallRetList(): array
    {
        return $this->content['RecallRetList'];
    }
}
