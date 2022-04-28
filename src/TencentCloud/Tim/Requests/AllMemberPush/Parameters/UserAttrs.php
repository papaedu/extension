<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class UserAttrs extends Parameter
{
    /**
     * UserAttrs constructor.
     *
     * @param  string  $toAccount
     * @param  array  $attrs
     */
    public function __construct(string $toAccount, array $attrs)
    {
        $this->setUserAttr($toAccount, $attrs);
    }

    /**
     * @param  string  $toAccount
     * @param  array  $attrs
     * @return $this
     */
    public function setUserAttr(string $toAccount, array $attrs): self
    {
        $this->parameters[] = [
            'To_Account' => $toAccount,
            'Attrs' => $attrs,
        ];

        return $this;
    }
}
