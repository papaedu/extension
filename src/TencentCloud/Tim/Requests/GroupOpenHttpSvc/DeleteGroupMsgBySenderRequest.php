<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class DeleteGroupMsgBySenderRequest extends TimRequest
{
    /**
     * DeleteGroupMsgBySenderRequest constructor.
     *
     * @param  string  $groupId
     * @param  string  $senderAccount
     */
    public function __construct(string $groupId, string $senderAccount)
    {
        $this->setGroupId($groupId)
            ->setSenderAccount($senderAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/delete_group_msg_by_sender';
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
     * @param  string  $senderAccount
     * @return $this
     */
    public function setSenderAccount(string $senderAccount): self
    {
        $this->setParameter('Sender_Account', $senderAccount);

        return $this;
    }
}
