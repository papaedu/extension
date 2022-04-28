<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\AppMemberDefinedData;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ModifyGroupMemberInfoRequest extends TimRequest
{
    /**
     * ModifyGroupMemberInfoRequest constructor.
     *
     * @param  string  $groupId
     * @param  string  $memberAccount
     */
    public function __construct(string $groupId, string $memberAccount)
    {
        $this->setGroupId($groupId)
            ->setMemberAccount($memberAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/modify_group_member_info';
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
     * @param  string  $memberAccount
     * @return $this
     */
    public function setMemberAccount(string $memberAccount): self
    {
        $this->setParameter('Member_Account', $memberAccount);

        return $this;
    }

    /**
     * @param  string  $role
     * @return $this
     */
    public function setRole(string $role): self
    {
        $this->setParameter('Role', $role);

        return $this;
    }

    /**
     * @param  string  $msgFlag
     * @return $this
     */
    public function setMsgFlag(string $msgFlag): self
    {
        $this->setParameter('MsgFlag', $msgFlag);

        return $this;
    }

    /**
     * @param  string  $nameCard
     * @return $this
     */
    public function setNameCard(string $nameCard): self
    {
        $this->setParameter('NameCard', $nameCard);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\AppMemberDefinedData  $appMemberDefinedData
     * @return $this
     */
    public function setAppMemberDefinedData(AppMemberDefinedData $appMemberDefinedData): self
    {
        $this->setParameter('AppMemberDefinedData', $appMemberDefinedData);

        return $this;
    }

    /**
     * @param  int  $shutUpTime
     * @return $this
     */
    public function setShutUpTime(int $shutUpTime): self
    {
        $this->setParameter('ShutUpTime', $shutUpTime);

        return $this;
    }
}
