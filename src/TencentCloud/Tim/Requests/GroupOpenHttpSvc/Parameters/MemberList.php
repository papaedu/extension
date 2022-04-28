<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class MemberList extends Parameter
{
    /**
     * MemberList constructor.
     *
     * @param  string  $memberAccount
     */
    public function __construct(string $memberAccount = '')
    {
        if ($memberAccount) {
            $this->setMemberAccount($memberAccount);
        }
    }

    /**
     * @param  string  $memberAccount
     */
    public function setMemberAccount(string $memberAccount)
    {
        $this->parameters[] = [
            'Member_Account' => $memberAccount,
        ];
    }

    /**
     * @param  array  $memberAccounts
     */
    public function setMemberAccounts(array $memberAccounts)
    {
        foreach ($memberAccounts as $memberAccount) {
            $this->parameters[] = [
                'Member_Account' => $memberAccount,
            ];
        }
    }

    /**
     * @param  string  $memberAccount
     * @param  string  $role
     * @param  int  $joinTime
     * @param  int  $unreadMsgNum
     * @return $this
     */
    public function setMember(
        string $memberAccount,
        string $role = '',
        int $joinTime = 0,
        int $unreadMsgNum = 0
    ): self {
        $this->parameters[] = [
            'Member_Account' => $memberAccount,
            'Role' => $role,
            'JoinTime' => $joinTime,
            'UnreadMsgNum' => $unreadMsgNum,
        ];

        return $this;
    }
}
