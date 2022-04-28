<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Profile;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class PortraitGetRequest extends TimRequest
{
    /**
     * PortraitGetRequest constructor.
     *
     * @param  array  $toAccount
     * @param  array  $tagList
     */
    public function __construct(array $toAccount, array $tagList)
    {
        $this->setToAccount($toAccount)
            ->setTagList($tagList);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/profile/portrait_get';
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
