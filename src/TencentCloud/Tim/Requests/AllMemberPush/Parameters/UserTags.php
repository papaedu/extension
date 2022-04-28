<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class UserTags extends Parameter
{
    /**
     * UserTags constructor.
     *
     * @param  string  $toAccount
     * @param  array  $tags
     */
    public function __construct(string $toAccount, array $tags)
    {
        $this->setUserTags($toAccount, $tags);
    }

    /**
     * @param  string  $toAccount
     * @param  array  $tags
     * @return $this
     */
    public function setUserTags(string $toAccount, array $tags): self
    {
        $this->parameters[] = [
            'To_Account' => $toAccount,
            'Tags' => $tags,
        ];

        return $this;
    }
}
