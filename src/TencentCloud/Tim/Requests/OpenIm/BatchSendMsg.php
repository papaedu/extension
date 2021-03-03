<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class BatchSendMsg extends TimRequest
{
    /**
     * BatchSendMsg constructor.
     *
     * @param  array  $toAccount
     * @param $msgRandom
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @param  string  $fromAccount
     */
    public function __construct(array $toAccount, $msgRandom, MsgBody $msgBody, string $fromAccount = '')
    {
        $this->setToAccount($toAccount)->setMsgRandom($msgRandom)->setMsgBody($msgBody)->setFromAccount($fromAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openim/batchsendmsg';
    }

    /**
     * @param  array  $toAccount
     * @return $this
     */
    public function setToAccount(array $toAccount):BatchSendMsg
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  int  $msgRandom
     * @return $this
     */
    public function setMsgRandom(int $msgRandom): BatchSendMsg
    {
        $this->setParameter('MsgRandom', $msgRandom);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @return $this
     */
    public function setMsgBody(MsgBody $msgBody): BatchSendMsg
    {
        $this->setParameter('MsgBody', $msgBody);

        return $this;
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): BatchSendMsg
    {
        if ($fromAccount) {
            $this->setParameter('From_Account', $fromAccount);
        }

        return $this;
    }

    /**
     * @param  int  $syncOtherMachine
     * @return $this
     */
    public function setSyncOtherMachine(int $syncOtherMachine): BatchSendMsg
    {
        $this->setParameter('SyncOtherMachine', $syncOtherMachine);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo  $offlinePushInfo
     * @return $this
     */
    public function setOfflinePushInfo(OfflinePushInfo $offlinePushInfo): BatchSendMsg
    {
        $this->setParameter('OfflinePushInfo', $offlinePushInfo);

        return $this;
    }
}
