<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetGroupInfoResponse extends TimResponse
{
    public function getGroupInfo(): array
    {
        return $this->content['GroupInfo'];
    }
}
