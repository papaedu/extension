<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class AddGroupMemberResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getMemberList(): array
    {
        return $this->content['MemberList'];
    }

    /**
     * @return string
     */
    public function getMemberAccount(): string
    {
        return $this->content['Member_Account'];
    }

    /**
     * @return int
     */
    public function getResult(): int
    {
        return $this->content['Result'];
    }
}
