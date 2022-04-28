<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\AddFriendItem;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class FriendImportRequest extends TimRequest
{
    /**
     * FriendImportRequest constructor.
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
        return 'v4/sns/friend_import';
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
}
