<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Profile;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class PortraitGet extends TimRequest
{
    /**
     * PortraitGet constructor.
     *
     * @param  array  $toAccount
     * @param  array  $tagList
     */
    public function __construct(array $toAccount, array $tagList)
    {
        $this->setToAccount($toAccount)->setTagList($tagList);
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
    public function setToAccount(array $toAccount): PortraitGet
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  array  $tagList
     * @return $this
     */
    public function setTagList(array $tagList): PortraitGet
    {
        $this->setParameter('TagList', $tagList);

        return $this;
    }
}
