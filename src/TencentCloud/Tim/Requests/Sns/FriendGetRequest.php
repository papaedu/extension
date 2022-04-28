<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class FriendGetRequest extends TimRequest
{
    /**
     * FriendGetRequest constructor.
     *
     * @param  string  $fromAccount
     * @param  int  $startIndex
     */
    public function __construct(string $fromAccount, int $startIndex)
    {
        $this->setFromAccount($fromAccount)
            ->setStartIndex($startIndex);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/friend_get';
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
     * @param  int  $startIndex
     * @return $this
     */
    public function setStartIndex(int $startIndex): self
    {
        $this->setParameter('StartIndex', $startIndex);

        return $this;
    }

    /**
     * @param  int  $standardSequence
     * @return $this
     */
    public function setStandardSequence(int $standardSequence): self
    {
        $this->setParameter('StandardSequence', $standardSequence);

        return $this;
    }

    /**
     * @param  int  $customSequence
     * @return $this
     */
    public function setCustomSequence(int $customSequence): self
    {
        $this->setParameter('CustomSequence', $customSequence);

        return $this;
    }
}
