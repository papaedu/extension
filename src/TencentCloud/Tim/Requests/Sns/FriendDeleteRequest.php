<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class FriendDeleteRequest extends TimRequest
{
    /**
     * FriendDeleteRequest constructor.
     *
     * @param  string  $fromAccount
     * @param  array  $toAccount
     */
    public function __construct(string $fromAccount, array $toAccount)
    {
        $this->setFromAccount($fromAccount)
            ->setToAccount($toAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/friend_delete';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): FriendDeleteRequest
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  array  $toAccount
     * @return $this
     */
    public function setToAccount(array $toAccount): FriendDeleteRequest
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  string  $deleteType
     * @return $this
     */
    public function setDeleteType(string $deleteType): FriendDeleteRequest
    {
        $this->setParameter('DeleteType', $deleteType);

        return $this;
    }
}
