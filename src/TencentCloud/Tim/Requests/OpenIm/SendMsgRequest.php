<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class SendMsgRequest extends TimRequest
{
    /**
     * SendMsgRequest constructor.
     *
     * @param  int  $syncOtherMachine
     * @param  string  $toAccount
     * @param  int  $msgLifeTime
     * @param  int  $msgRandom
     * @param  int  $msgTimeStamp
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     */
    public function __construct(
        int $syncOtherMachine,
        string $toAccount,
        int $msgLifeTime,
        int $msgRandom,
        int $msgTimeStamp,
        MsgBody $msgBody
    ) {
        $this->setSyncOtherMachine($syncOtherMachine)
            ->setToAccount($toAccount)
            ->setMsgLifeTime($msgLifeTime)
            ->setMsgRandom($msgRandom)
            ->setMsgTimeStamp($msgTimeStamp)
            ->setMsgBody($msgBody);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openim/sendmsg';
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
     * @param  string  $toAccount
     * @return $this
     */
    public function setToAccount(string $toAccount): SendMsgRequest
    {
        $this->setParameter('To_Account', $toAccount);

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
     * @param  int  $msgRandom
     * @return $this
     */
    public function setMsgRandom(int $msgRandom): SendMsgRequest
    {
        $this->setParameter('MsgRandom', $msgRandom);

        return $this;
    }

    /**
     * @param  int  $msgTimeStamp
     * @return $this
     */
    public function setMsgTimeStamp(int $msgTimeStamp): SendMsgRequest
    {
        $this->setParameter('MsgTimeStamp', $msgTimeStamp);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @return $this
     */
    public function setMsgBody(MsgBody $msgBody): SendMsgRequest
    {
        $this->setParameter('MsgBody', $msgBody->getParameters());

        return $this;
    }
}
