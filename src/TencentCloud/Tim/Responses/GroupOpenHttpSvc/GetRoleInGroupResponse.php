<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetRoleInGroupResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getUserIdList(): array
    {
        return $this->content['UserIdList'];
    }
}
