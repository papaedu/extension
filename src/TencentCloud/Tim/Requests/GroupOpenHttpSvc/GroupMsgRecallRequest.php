<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\MsgSeqList;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GroupMsgRecallRequest extends TimRequest
{
    /**
     * GroupMsgRecallRequest constructor.
     *
     * @param  string  $groupId
     * @param  array  $msgSeqList
     */
    public function __construct(string $groupId, array $msgSeqList)
    {
        $this->setGroupId($groupId)
            ->setMsgSeqList($msgSeqList);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/group_msg_recall';
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
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\MsgSeqList  $msgSeqList
     * @return $this
     */
    public function setMsgSeqList(MsgSeqList $msgSeqList): self
    {
        $this->setParameter('MsgSeqList', $msgSeqList);

        return $this;
    }
}
