<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GroupDeleteRequest extends TimRequest
{
    /**
     * GroupDeleteRequest constructor.
     *
     * @param  string  $fromAccount
     * @param  array  $groupName
     */
    public function __construct(string $fromAccount, array $groupName)
    {
        $this->setFromAccount($fromAccount)
            ->setGroupName($groupName);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/group_delete';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): self
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  array  $groupName
     * @return $this
     */
    public function setGroupName(array $groupName): self
    {
        $this->setParameter('GroupName', $groupName);

        return $this;
    }
}
