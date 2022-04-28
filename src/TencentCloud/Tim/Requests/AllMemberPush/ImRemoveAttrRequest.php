<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImRemoveAttrRequest extends TimRequest
{
    /**
     * ImRemoveAttrRequest constructor.
     *
     * @param  string  $toAccount
     * @param  array  $attrs
     */
    public function __construct(string $toAccount, array $attrs)
    {
        $this->setToAccount($toAccount)
            ->setAttrs($attrs);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/all_member_push/im_remove_attr';
    }

    /**
     * @param  string  $toAccount
     * @return $this
     */
    public function setToAccount(string $toAccount): self
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  array  $attrs
     * @return $this
     */
    public function setAttrs(array $attrs): self
    {
        $this->setParameter('UserAttrs', $attrs);

        return $this;
    }
}
