<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetGroupMemberInfoRequest extends TimRequest
{
    /**
     * GetGroupMemberInfoRequest constructor.
     *
     * @param  string  $groupId
     */
    public function __construct(string $groupId)
    {
        $this->setGroupId($groupId);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/get_group_member_info';
    }

    /**
     * @param  string  $groupId
     * @return $this
     */
    public function setGroupId(string $groupId): GetGroupMemberInfoRequest
    {
        $this->setParameter('GroupId', $groupId);

        return $this;
    }

    /**
     * @param  array  $memberInfoFilter
     * @return $this
     */
    public function setMemberInfoFilter(array $memberInfoFilter): GetGroupMemberInfoRequest
    {
        $this->setParameter('MemberInfoFilter', $memberInfoFilter);

        return $this;
    }

    /**
     * @param  array  $appDefinedDataFilterGroupMember
     * @return $this
     */
    public function setAppDefinedDataFilterGroupMember(
        array $appDefinedDataFilterGroupMember
    ): GetGroupMemberInfoRequest {
        $this->setParameter('AppDefinedDatFilterGroupMember', $appDefinedDataFilterGroupMember);

        return $this;
    }

    /**
     * @param  int  $limit
     * @return $this
     */
    public function setLimit(int $limit): GetGroupMemberInfoRequest
    {
        $this->setParameter('Limit', $limit);

        return $this;
    }

    /**
     * @param  int  $offset
     * @return $this
     */
    public function setOffset(int $offset): GetGroupMemberInfoRequest
    {
        $this->setParameter('Offset', $offset);

        return $this;
    }
}
