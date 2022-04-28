<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImGetTagRequest extends TimRequest
{
    /**
     * ImGetTagRequest constructor.
     *
     * @param  array  $toAccount
     */
    public function __construct(array $toAccount)
    {
        $this->setToAccount($toAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/all_member_push/im_get_tag';
    }

    /**
     * @param  array  $toAccount
     * @return $this
     */
    public function setToAccount(array $toAccount): self
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }
}
