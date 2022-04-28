<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImportGroupMsgRequest extends TimRequest
{
    /**
     * ImportGroupMsgRequest constructor.
     *
     * @param  string  $groupId
     * @param  string  $msgList
     * @param  string  $fromAccount
     * @param  int  $sendTime
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\MsgBody  $msgBody
     */
    public function __construct(string $groupId, string $msgList, string $fromAccount, int $sendTime, MsgBody $msgBody)
    {
        $this->setGroupId($groupId)
            ->setMsgList($msgList)
            ->setFromAccount($fromAccount)
            ->setSendTime($sendTime)
            ->setMsgBody($msgBody);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/import_group_msg';
    }

    /**
     * @param  string  $groupId
     * @return $this
     */
    public function setGroupId(string $groupId): self
    {
        $this->setParameter('GroupId', $groupId);

        return $this;
    }

    /**
     * @param  string  $msgList
     * @return $this
     */
    public function setMsgList(string $msgList): self
    {
        $this->setParameter('MsgList', $msgList);

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
     * @param  int  $sendTime
     * @return $this
     */
    public function setSendTime(int $sendTime): self
    {
        $this->setParameter('SendTime', $sendTime);

        return $this;
    }

    /**
     * @param  int  $random
     * @return $this
     */
    public function setRandom(int $random): self
    {
        $this->setParameter('Random', $random);

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
}
