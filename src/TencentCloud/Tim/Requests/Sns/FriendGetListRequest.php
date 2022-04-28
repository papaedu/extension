<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class FriendGetListRequest extends TimRequest
{
    /**
     * FriendGetListRequest constructor.
     *
     * @param  string  $fromAccount
     * @param  array  $toAccount
     * @param  array  $tagList
     */
    public function __construct(string $fromAccount, array $toAccount, array $tagList)
    {
        $this->setFromAccount($fromAccount)
            ->setToAccount($toAccount)
            ->setTagList($tagList);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/friend_get_list';
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
     * @param  array  $tagList
     * @return $this
     */
    public function setTagList(array $tagList): self
    {
        $this->setParameter('TagList', $tagList);

        return $this;
    }
}
