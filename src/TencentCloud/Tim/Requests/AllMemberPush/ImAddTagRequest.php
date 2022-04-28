<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters\UserTags;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImAddTagRequest extends TimRequest
{
    /**
     * ImAddTagRequest constructor.
     *
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters\UserTags  $userTags
     */
    public function __construct(UserTags $userTags)
    {
        $this->setUserTags($userTags);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/all_member_push/im_add_tag';
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters\UserTags  $userTags
     * @return $this
     */
    public function setUserTags(UserTags $userTags): self
    {
        $this->setParameter('UserTags', $userTags);

        return $this;
    }
}
