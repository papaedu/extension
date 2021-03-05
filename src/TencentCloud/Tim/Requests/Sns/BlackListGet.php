<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class BlackListGet extends TimRequest
{
    /**
     * BlackListGet constructor.
     *
     * @param  string  $fromAccount
     * @param  int  $startIndex
     * @param  int  $maxLimited
     * @param  int  $lastSequence
     */
    public function __construct(string $fromAccount, int $startIndex, int $maxLimited, int $lastSequence)
    {
        $this->setFromAccount($fromAccount)
            ->setStartIndex($startIndex)
            ->setMaxLimited($maxLimited)
            ->setLastSequence($lastSequence);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/sns/black_list_get';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): BlackListGet
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  int  $startIndex
     * @return $this
     */
    public function setStartIndex(int $startIndex): BlackListGet
    {
        $this->setParameter('StartIndex', $startIndex);

        return $this;
    }

    /**
     * @param  int  $maxLimited
     * @return $this
     */
    public function setMaxLimited(int $maxLimited): BlackListGet
    {
        $this->setParameter('MaxLimited', $maxLimited);

        return $this;
    }

    /**
     * @param  int  $lastSequence
     * @return $this
     */
    public function setLastSequence(int $lastSequence): BlackListGet
    {
        $this->setParameter('LastSequence', $lastSequence);

        return $this;
    }
}
