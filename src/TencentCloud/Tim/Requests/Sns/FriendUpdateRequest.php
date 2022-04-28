<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\UpdateItem;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class FriendUpdateRequest extends TimRequest
{
    /**
     * FriendUpdateRequest constructor.
     *
     * @param  string  $fromAccount
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\UpdateItem  $updateItem
     */
    public function __construct(string $fromAccount, UpdateItem $updateItem)
    {
        $this->setFromAccount($fromAccount)
            ->setUpdateItem($updateItem);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/friend_update';
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
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters\UpdateItem  $updateItem
     * @return $this
     */
    public function setUpdateItem(UpdateItem $updateItem): self
    {
        $this->setParameter('UpdateItem', $updateItem);

        return $this;
    }
}
