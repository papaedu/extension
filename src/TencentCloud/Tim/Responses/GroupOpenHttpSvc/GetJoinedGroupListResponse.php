<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetJoinedGroupListResponse extends TimResponse
{
    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->content['TotalCount'];
    }

    /**
     * @return array
     */
    public function getGroupIdList(): array
    {
        return $this->content['GroupIdList'];
    }
}
