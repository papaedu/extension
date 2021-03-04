<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class SetUnreadMsgNumRequest extends TimRequest
{
    /**
     * SetUnreadMsgNumResponse constructor.
     *
     * @param  string  $groupId
     * @param  string  $memberAccount
     * @param  int  $unreadMsgNum
     */
    public function __construct(string $groupId, string $memberAccount, int $unreadMsgNum)
    {
        $this->setGroupId($groupId)
            ->setMemberAccount($memberAccount)
            ->setUnreadMsgNum($unreadMsgNum);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/set_unread_msg_num';
    }

    /**
     * @param  string  $groupId
     * @return $this
     */
    public function setGroupId(string $groupId): SetUnreadMsgNumRequest
    {
        $this->setParameter('GroupId', $groupId);

        return $this;
    }

    /**
     * @param  string  $memberAccount
     * @return $this
     */
    public function setMemberAccount(string $memberAccount): SetUnreadMsgNumRequest
    {
        $this->setParameter('Member_Account', $memberAccount);

        return $this;
    }

    /**
     * @param  int  $unreadMsgNum
     * @return $this
     */
    public function setUnreadMsgNum(int $unreadMsgNum): SetUnreadMsgNumRequest
    {
        $this->setParameter('UnreadMsgNum', $unreadMsgNum);

        return $this;
    }
}
