<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class ImGetAttrResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getUserAttrs(): array
    {
        return $this->content['UserAttrs'];
    }
}
