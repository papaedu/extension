<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Enums\DeleteType;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class FriendDeleteAllRequest extends TimRequest
{
    /**
     * FriendDeleteAllRequest constructor.
     *
     * @param  string  $fromAccount
     */
    public function __construct(string $fromAccount)
    {
        $this->setFromAccount($fromAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/friend_delete_all';
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
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Enums\DeleteType  $deleteType
     * @return $this
     */
    public function setDeleteType(DeleteType $deleteType): self
    {
        $this->setParameter('DeleteType', $deleteType);

        return $this;
    }
}
