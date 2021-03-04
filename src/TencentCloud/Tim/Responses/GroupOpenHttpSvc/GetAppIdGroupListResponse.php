<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetAppIdGroupListResponse extends TimResponse
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

    /**
     * @return int
     */
    public function getNext(): int
    {
        return $this->content['Next'];
    }
}
