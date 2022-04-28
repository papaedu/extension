<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\MemberList;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImportGroupMemberRequest extends TimRequest
{
    /**
     * ImportGroupMemberRequest constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/import_group_member';
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
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\MemberList  $memberList
     * @return $this
     */
    public function setMemberList(MemberList $memberList): self
    {
        $this->setParameter('MemberList', $memberList);

        return $this;
    }
}
