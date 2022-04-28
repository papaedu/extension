<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class AdminGetRoamMsgRequest extends TimRequest
{
    /**
     * AdminGetRoamMsgRequest constructor.
     *
     * @param  string  $fromAccount
     * @param  string  $toAccount
     * @param  int  $maxCnt
     * @param  int  $minTime
     * @param  int  $maxTime
     */
    public function __construct(string $fromAccount, string $toAccount, int $maxCnt, int $minTime, int $maxTime)
    {
        $this->setFromAccount($fromAccount)
            ->setToAccount($toAccount)
            ->setMaxCnt($maxCnt)
            ->setMinTime($minTime)
            ->setMaxTime($maxTime);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openim/admin_getroammsg';
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): static
    {
        if ($fromAccount) {
            $this->setParameter('From_Account', $fromAccount);
        }

        return $this;
    }

    /**
     * @param  string  $toAccounts
     * @return $this
     */
    public function setToAccount(string $toAccounts): static
    {
        $this->setParameter('To_Account', $toAccounts);

        return $this;
    }

    /**
     * @param  int  $maxCnt
     * @return $this
     */
    public function setMaxCnt(int $maxCnt): static
    {
        $this->setParameter('MaxCnt', $maxCnt);

        return $this;
    }

    /**
     * @param  int  $minTime
     * @return $this
     */
    public function setMinTime(int $minTime): static
    {
        $this->setParameter('MinTime', $minTime);

        return $this;
    }

    /**
     * @param  int  $maxTime
     * @return $this
     */
    public function setMaxTime(int $maxTime): static
    {
        $this->setParameter('MaxTime', $maxTime);

        return $this;
    }

    /**
     * @param  string  $lastMsgKey
     * @return $this
     */
    public function setLastMsgKey(string $lastMsgKey): static
    {
        $this->setParameter('LastMsgKey', $lastMsgKey);

        return $this;
    }
}
