<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImportMsg extends TimRequest
{
    /**
     * ImportMsg constructor.
     *
     * @param  int  $syncFromOldSystem
     * @param  string  $fromAccount
     * @param  string  $toAccount
     * @param  int  $msgRandom
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     */
    public function __construct(
        int $syncFromOldSystem,
        string $fromAccount,
        string $toAccount,
        int $msgRandom,
        MsgBody $msgBody
    ) {
        $this->setSyncOtherMachine($syncFromOldSystem)
            ->setFromAccount($fromAccount)
            ->setToAccount($toAccount)
            ->setMsgRandom($msgRandom)
            ->setMsgBody($msgBody);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openim/importmsg';
    }

    /**
     * @param  int  $syncOtherMachine
     * @return $this
     */
    public function setSyncOtherMachine(int $syncOtherMachine): ImportMsg
    {
        $this->setParameter('SyncOtherMachine', $syncOtherMachine);

        return $this;
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): ImportMsg
    {
        if ($fromAccount) {
            $this->setParameter('From_Account', $fromAccount);
        }

        return $this;
    }

    /**
     * @param $toAccounts
     * @return $this
     */
    public function setToAccount($toAccounts): ImportMsg
    {
        $this->setParameter('To_Account', $toAccounts);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @return $this
     */
    public function setMsgBody(MsgBody $msgBody): ImportMsg
    {
        $this->setParameter('MsgBody', $msgBody);

        return $this;
    }

    /**
     * @param  int  $msgRandom
     * @return $this
     */
    public function setMsgRandom(int $msgRandom): ImportMsg
    {
        $this->setParameter('MsgRandom', $msgRandom);

        return $this;
    }
}
