<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\MemberList;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class AddGroupMemberRequest extends TimRequest
{
    /**
     * AddGroupMemberRequest constructor.
     *
     * @param  string  $groupId
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\MemberList  $memberList
     */
    public function __construct(string $groupId, MemberList $memberList)
    {
        $this->setGroupId($groupId)
            ->setMemberList($memberList);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/add_group_member';
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
     * @param  int  $silence
     * @return $this
     */
    public function setSilence(int $silence): self
    {
        $this->setParameter('Silence', $silence);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\MemberList  $memberList
     * @return $this
     */
    public function setMemberList(MemberList $memberList): self
    {
        $this->setParameter('MemberList', $memberList);

        return $this;
    }
}
