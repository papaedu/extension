<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class GetGroupMemberInfoResponse extends TimResponse
{
    /**
     * @return int
     */
    public function getMemberNum(): int
    {
        return $this->content['MemberNum'];
    }

    /**
     * @return array
     */
    public function getMemberList(): array
    {
        return $this->content['MemberList'];
    }

    /**
     * @return array
     */
    public function getAppMemberDefinedData(): array
    {
        return $this->content['AppMemberDefinedData'];
    }
}
