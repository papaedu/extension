<?php

namespace Papaedu\Extension\TencentCloud\Tim\Responses\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Responses\TimResponse;

class ImGetAttrNameResponse extends TimResponse
{
    /**
     * @return array
     */
    public function getAttrNames(): array
    {
        return $this->content['AttrNames'];
    }
}
