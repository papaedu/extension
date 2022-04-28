<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters\Condition;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImPushRequest extends TimRequest
{
    /**
     * ImPushRequest constructor.
     *
     * @param  int  $msgRandom
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @param  string  $fromAccount
     */
    public function __construct(int $msgRandom, MsgBody $msgBody, string $fromAccount = '')
    {
        $this->setMsgRandom($msgRandom)
            ->setMsgBody($msgBody)
            ->setFromAccount($fromAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/all_member_push/im_push';
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\Parameters\Condition  $condition
     * @return $this
     */
    public function setCondition(Condition $condition): ImPushRequest
    {
        $this->setParameter('Condition', $condition);

        return $this;
    }

    /**
     * @param  int  $msgRandom
     * @return $this
     */
    public function setMsgRandom(int $msgRandom): self
    {
        $this->setParameter('MsgRandom', $msgRandom);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @return $this
     */
    public function setMsgBody(MsgBody $msgBody): self
    {
        $this->setParameter('MsgBody', $msgBody);

        return $this;
    }

    /**
     * @param  int  $msgLifeTime
     * @return $this
     */
    public function setMsfLifeTime(int $msgLifeTime): self
    {
        $this->setParameter('MsgLifeTime', $msgLifeTime);

        return $this;
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): self
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo  $offlinePushInfo
     * @return $this
     */
    public function setOfflinePushInfo(OfflinePushInfo $offlinePushInfo): self
    {
        $this->setParameter('OfflinePushInfo', $offlinePushInfo);

        return $this;
    }
}
