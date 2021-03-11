<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\ResponseFilter;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetJoinedGroupListRequest extends TimRequest
{
    /**
     * GetJoinedGroupListRequest constructor.
     *
     * @param  string  $memberAccount
     */
    public function __construct(string $memberAccount)
    {
        $this->setMemberAccount($memberAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/get_joined_group_list';
    }

    /**
     * @param  string  $memberAccount
     * @return $this
     */
    public function setMemberAccount(string $memberAccount): GetJoinedGroupListRequest
    {
        $this->setParameter('Member_Account', $memberAccount);

        return $this;
    }

    /**
     * @param  int  $withHugeGroups
     * @return $this
     */
    public function setWithHugeGroups(int $withHugeGroups): GetJoinedGroupListRequest
    {
        $this->setParameter('WithHugeGroups', $withHugeGroups);

        return $this;
    }

    /**
     * @param  int  $withNoActiveGroups
     * @return $this
     */
    public function setWithNoActiveGroups(int $withNoActiveGroups): GetJoinedGroupListRequest
    {
        $this->setParameter('WithNoActiveGroups', $withNoActiveGroups);

        return $this;
    }

    /**
     * @param  int  $limit
     * @return $this
     */
    public function setLimit(int $limit): GetJoinedGroupListRequest
    {
        $this->setParameter('Limit', $limit);

        return $this;
    }

    /**
     * @param  int  $offset
     * @return $this
     */
    public function setOffset(int $offset): GetJoinedGroupListRequest
    {
        $this->setParameter('Offset', $offset);

        return $this;
    }

    /**
     * @param  string  $groupType
     * @return $this
     */
    public function setGroupType(string $groupType): GetJoinedGroupListRequest
    {
        $this->setParameter('GroupType', $groupType);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\ResponseFilter  $responseFilter
     * @return $this
     */
    public function setResponseFilter(ResponseFilter $responseFilter): GetJoinedGroupListRequest
    {
        $this->setParameter('ResponseFilter', $responseFilter);

        return $this;
    }
}
