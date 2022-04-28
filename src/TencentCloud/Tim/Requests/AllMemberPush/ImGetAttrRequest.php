<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImGetAttrRequest extends TimRequest
{
    /**
     * ImGetAttrRequest constructor.
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
        return 'v4/all_member_push/im_get_attr';
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
