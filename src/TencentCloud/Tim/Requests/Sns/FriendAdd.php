<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\AddFriendItem;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class FriendAdd extends TimRequest
{
    /**
     * FriendAdd constructor.
     *
     * @param  string  $fromAccount
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\AddFriendItem  $addFriendItem
     */
    public function __construct(string $fromAccount, AddFriendItem $addFriendItem, string $addTyp, int $forceAddFlags)
    {
        $this->setFromAccount($fromAccount)
            ->setAddFriendItem($addFriendItem)
            ->setAddType($addTyp)
            ->setForceAddFlags($forceAddFlags);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/friend_add';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): FriendAdd
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\AddFriendItem  $addFriendItem
     * @return $this
     */
    public function setAddFriendItem(AddFriendItem $addFriendItem): FriendAdd
    {
        $this->setParameter('AddFriendItem', $addFriendItem);

        return $this;
    }

    /**
     * @param  string  $addType
     * @return $this
     */
    public function setAddType(string $addType): FriendAdd
    {
        $this->setParameter('AddType', $addType);

        return $this;
    }

    /**
     * @param  int  $forceAddFlags
     * @return $this
     */
    public function setForceAddFlags(int $forceAddFlags): FriendAdd
    {
        $this->setParameter('ForceAddFlags', $forceAddFlags);

        return $this;
    }
}
