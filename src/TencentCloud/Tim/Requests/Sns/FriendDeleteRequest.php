<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Enums\DeleteType;
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
    public function setFromAccount(string $fromAccount): self
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  array  $toAccount
     * @return $this
     */
    public function setToAccount(array $toAccount): self
    {
        $this->setParameter('To_Account', $toAccount);

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
