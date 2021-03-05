<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GroupAdd extends TimRequest
{
    /**
     * GroupAdd constructor.
     *
     * @param  string  $fromAccount
     * @param  array  $groupName
     * @param  array  $toAccount
     */
    public function __construct(string $fromAccount, array $groupName, array $toAccount)
    {
        $this->setFromAccount($fromAccount)->setGroupName($groupName)->setToAccount($toAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/group_add';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): GroupAdd
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  array  $groupName
     * @return $this
     */
    public function setGroupName(array $groupName): GroupAdd
    {
        $this->setParameter('GroupName', $groupName);

        return $this;
    }

    /**
     * @param  array  $toAccount
     * @return $this
     */
    public function setToAccount(array $toAccount): GroupAdd
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }
}
