<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class ImGetTagResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getUserTags(): array
    {
        return $this->content['UserTags'];
    }
}
