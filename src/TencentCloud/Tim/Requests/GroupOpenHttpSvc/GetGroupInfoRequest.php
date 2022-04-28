<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\ResponseFilter;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetGroupInfoRequest extends TimRequest
{
    /**
     * GetGroupInfoRequest constructor.
     *
     * @param  array  $groupIdList
     */
    public function __construct(array $groupIdList)
    {
        $this->setGroupIdList($groupIdList);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/get_group_info';
    }

    /**
     * @param  array  $groupIdList
     * @return $this
     */
    public function setGroupIdList(array $groupIdList): self
    {
        $this->setParameter('GroupIdList', $groupIdList);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\ResponseFilter  $responseFilter
     * @return $this
     */
    public function setResponseFilter(ResponseFilter $responseFilter): self
    {
        $this->setParameter('ResponseFilter', $responseFilter);

        return $this;
    }
}
