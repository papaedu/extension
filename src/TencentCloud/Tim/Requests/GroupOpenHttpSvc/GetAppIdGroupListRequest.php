<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetAppIdGroupListRequest extends TimRequest
{
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/get_appid_group_list';
    }

    /**
     * @param  int  $limit
     * @return $this
     */
    public function setLimit(int $limit): GetAppIdGroupListRequest
    {
        $this->setParameter('Limit', $limit);

        return $this;
    }

    /**
     * @param  int  $next
     * @return $this
     */
    public function setNext(int $next): GetAppIdGroupListRequest
    {
        $this->setParameter('Next', $next);

        return $this;
    }

    /**
     * @param  string  $groupType
     * @return $this
     */
    public function setGroupType(string $groupType): GetAppIdGroupListRequest
    {
        $this->setParameter('GroupType', $groupType);

        return $this;
    }
}
