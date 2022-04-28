<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters\UserAttrs;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImSetAttrRequest extends TimRequest
{
    /**
     * ImSetAttrRequest constructor.
     *
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters\UserAttrs  $userAttrs
     */
    public function __construct(UserAttrs $userAttrs)
    {
        $this->setUserAttrs($userAttrs);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/all_member_push/im_set_attr';
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters\UserAttrs  $userAttrs
     * @return $this
     */
    public function setUserAttrs(UserAttrs $userAttrs): self
    {
        $this->setParameter('UserAttrs', $userAttrs);

        return $this;
    }
}
