<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class SendGroupMsgRequest extends TimRequest
{
    /**
     * SendGroupMsgRequest constructor.
     *
     * @param  string  $groupId
     * @param  int  $random
     */
    public function __construct(string $groupId, int $random, MsgBody $msgBody)
    {
        $this->setGroupId($groupId)
            ->setRandom($random)
            ->setMsgBody($msgBody);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/send_group_msg';
    }

    public function setGroupId(string $groupId): SendGroupMsgRequest
    {
        $this->setParameter('GroupId', $groupId);

        return $this;
    }

    public function setRandom(int $random): SendGroupMsgRequest
    {
        $this->setParameter('Random', $random);

        return $this;
    }

    public function setMsgPriority(string $msgPriority): SendGroupMsgRequest
    {
        $this->setParameter('MsgPriority', $msgPriority);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     * @return $this
     */
    public function setMsgBody(MsgBody $msgBody): SendGroupMsgRequest
    {
        $this->setParameter('MsgBody', $msgBody);

        return $this;
    }

    /**
     * @param  string  $fromAccount
     * @return $this
     */
    public function setFromAccount(string $fromAccount): SendGroupMsgRequest
    {
        $this->setParameter('From_Account', $fromAccount);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\OfflinePushInfo  $offlinePushInfo
     * @return $this
     */
    public function setOfflinePushInfo(OfflinePushInfo $offlinePushInfo): SendGroupMsgRequest
    {
        $this->setParameter('OfflinePushInfo', $offlinePushInfo);

        return $this;
    }

    /**
     * @param  array  $forbidCallbackControl
     * @return $this
     */
    public function setForbidCallbackControl(array $forbidCallbackControl): SendGroupMsgRequest
    {
        $this->setParameter('ForbidCallbackControl', $forbidCallbackControl);

        return $this;
    }

    /**
     * @param  int  $onlineOnlyFlag
     * @return $this
     */
    public function setOnlineOnlyFlag(int $onlineOnlyFlag): SendGroupMsgRequest
    {
        $this->setParameter('OnlineOnlyFlag', $onlineOnlyFlag);

        return $this;
    }
}
