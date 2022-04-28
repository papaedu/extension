<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Enums\AddType;
use Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\AddFriendItem;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class FriendAddRequest extends TimRequest
{
    /**
     * FriendAddRequest constructor.
     *
     * @param  string  $fromAccount
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\AddFriendItem  $addFriendItem
     */
    public function __construct(string $fromAccount, AddFriendItem $addFriendItem)
    {
        $this->setFromAccount($fromAccount)
            ->setAddFriendItem($addFriendItem);
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
    public function setFromAccount(string $fromAccount): self
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\AddFriendItem  $addFriendItem
     * @return $this
     */
    public function setAddFriendItem(AddFriendItem $addFriendItem): self
    {
        $this->setParameter('AddFriendItem', $addFriendItem);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Enums\AddType  $addType
     * @return $this
     */
    public function setAddType(AddType $addType): self
    {
        $this->setParameter('AddType', $addType);

        return $this;
    }

    /**
     * @param  int  $forceAddFlags
     * @return $this
     */
    public function setForceAddFlags(int $forceAddFlags): self
    {
        $this->setParameter('ForceAddFlags', $forceAddFlags);

        return $this;
    }
}
