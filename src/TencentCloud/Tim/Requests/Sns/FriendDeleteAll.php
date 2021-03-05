<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class FriendDeleteAll extends TimRequest
{
    /**
     * FriendDeleteAll constructor.
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
    public function setFromAccount(string $fromAccount): FriendDeleteAll
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  string  $deleteType
     * @return $this
     */
    public function setDeleteType(string $deleteType): FriendDeleteAll
    {
        $this->setParameter('DeleteType', $deleteType);

        return $this;
    }
}
