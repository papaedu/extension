<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class ImportGroupMemberResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getMemberList(): array
    {
        return $this->content['MemberList'];
    }
}
