<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class AdminGetRoamMsg extends TimRequest
{
    /**
     * AdminGetRoamMsg constructor.
     *
     * @param  string  $fromAccount
     * @param  string  $toAccount
     * @param  int  $maxCnt
     * @param  int  $minTime
     * @param  int  $maxTime
     */
    public function __construct(
        string $fromAccount,
        string $toAccount,
        int $maxCnt,
        int $minTime,
        int $maxTime
    ) {
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
    public function setFromAccount(string $fromAccount): AdminGetRoamMsg
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
    public function setToAccount(string $toAccounts): AdminGetRoamMsg
    {
        $this->setParameter('To_Account', $toAccounts);

        return $this;
    }

    /**
     * @param  int  $maxCnt
     * @return $this
     */
    public function setMaxCnt(int $maxCnt): AdminGetRoamMsg
    {
        $this->setParameter('MaxCnt', $maxCnt);

        return $this;
    }

    /**
     * @param  int  $minTime
     * @return $this
     */
    public function setMinTime(int $minTime): AdminGetRoamMsg
    {
        $this->setParameter('MinTime', $minTime);

        return $this;
    }

    /**
     * @param  int  $maxTime
     * @return $this
     */
    public function setMaxTime(int $maxTime): AdminGetRoamMsg
    {
        $this->setParameter('MaxTime', $maxTime);

        return $this;
    }

    /**
     * @param  string  $lastMsgKey
     * @return $this
     */
    public function setLastMsgKey(string $lastMsgKey)
    {
        $this->setParameter('LastMsgKey', $lastMsgKey);

        return $this;
    }
}
