<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\ForbidCallbackControl;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\SyncOtherMachine;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class SendMsgRequest extends TimRequest
{
    /**
     * SendMsgRequest constructor.
     *
     * @param  string  $toAccount
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @param  string  $fromAccount
     * @param  int  $msgRandom
     */
    public function __construct(string $toAccount, MsgBody $msgBody, string $fromAccount = '', int $msgRandom = 0)
    {
        if (! $msgRandom) {
            $msgRandom = random_int(1, 9999999);
        }

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
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\SyncOtherMachine  $syncOtherMachine
     * @return $this
     */
    public function setSyncOtherMachine(SyncOtherMachine $syncOtherMachine): static
    {
        $this->setParameter('SyncOtherMachine', $syncOtherMachine);

        return $this;
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
     * @param  string  $toAccount
     * @return $this
     */
    public function setToAccount(string $toAccount): static
    {
        $this->setParameter('To_Account', $toAccount);

        return $this;
    }

    /**
     * @param  int  $msgLifeTime
     * @return $this
     */
    public function setMsgLifeTime(int $msgLifeTime): static
    {
        $this->setParameter('MsgLifeTime', $msgLifeTime);

        return $this;
    }

    /**
     * @param  int  $msgRandom
     * @return $this
     */
    public function setMsgRandom(int $msgRandom): static
    {
        $this->setParameter('MsgRandom', $msgRandom);

        return $this;
    }

    /**
     * @param  int  $msgTimestamp
     * @return $this
     */
    public function setMsgTimestamp(int $msgTimestamp): static
    {
        $this->setParameter('MsgTimeStamp', $msgTimestamp);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\ForbidCallbackControl  ...$forbidCallbackControl
     * @return $this
     */
    public function setForbidCallbackControl(ForbidCallbackControl ...$forbidCallbackControl): static
    {
        $this->setParameter('ForbidCallbackControl', array_map(fn ($value) => $value->value, $forbidCallbackControl));

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @return $this
     */
    public function setMsgBody(MsgBody $msgBody): static
    {
        $this->setParameter('MsgBody', $msgBody);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo  $offlinePushInfo
     * @return $this
     */
    public function setOfflinePushInfo(OfflinePushInfo $offlinePushInfo): static
    {
        $this->setParameter('OfflinePushInfo', $offlinePushInfo);

        return $this;
    }
}
