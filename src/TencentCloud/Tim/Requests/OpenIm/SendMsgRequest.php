<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class SendMsgRequest extends TimRequest
{
    /**
     * SendMsgRequest constructor.
     *
     * @param  string  $toAccount
     * @param  int  $msgRandom
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @param  string  $fromAccount
     */
    public function __construct(string $toAccount, int $msgRandom, MsgBody $msgBody, string $fromAccount = '')
    {
        $this->setToAccount($toAccount)
            ->setMsgRandom($msgRandom)
            ->setMsgBody($msgBody)
            ->setFromAccount($fromAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openim/sendmsg';
    }

    /**
     * @param  string  $toAccount
     * @return $this
     */
    public function setToAccount(string $toAccount): SendMsgRequest
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): SendMsgRequest
    {
        if ($fromAccount) {
            $this->setParameter('From_Account', $fromAccount);
        }

        return $this;
    }

    /**
     * @param  int  $msgRandom
     * @return $this
     */
    public function setMsgRandom(int $msgRandom): SendMsgRequest
    {
        $this->setParameter('MsgRandom', $msgRandom);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @return $this
     */
    public function setMsgBody(MsgBody $msgBody): SendMsgRequest
    {
        $this->setParameter('MsgBody', $msgBody);

        return $this;
    }

    /**
     * @param  int  $syncOtherMachine
     * @return $this
     */
    public function setSyncOtherMachine(int $syncOtherMachine): SendMsgRequest
    {
        $this->setParameter('SyncOtherMachine', $syncOtherMachine);

        return $this;
    }

    /**
     * @param  int  $msgLifeTime
     * @return $this
     */
    public function setMsgLifeTime(int $msgLifeTime): SendMsgRequest
    {
        $this->setParameter('MsgLifeTime', $msgLifeTime);

        return $this;
    }

    /**
     * @param  array  $forbidCallbackControl
     * @return $this
     */
    public function setForbidCallbackControl(array $forbidCallbackControl): SendMsgRequest
    {
        $this->setParameter('ForbidCallbackControl', $forbidCallbackControl);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo  $offlinePushInfo
     * @return $this
     */
    public function setOfflinePushInfo(OfflinePushInfo $offlinePushInfo): SendMsgRequest
    {
        $this->setParameter('OfflinePushInfo', $offlinePushInfo);

        return $this;
    }
}
