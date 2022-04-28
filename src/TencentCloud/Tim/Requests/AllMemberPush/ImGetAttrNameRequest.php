<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImGetAttrNameRequest extends TimRequest
{
    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/all_member_push/im_get_attr_name';
    }
}
