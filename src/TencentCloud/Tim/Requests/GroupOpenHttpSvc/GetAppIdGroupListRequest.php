<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums\GroupType;
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
    public function setLimit(int $limit): self
    {
        $this->setParameter('Limit', $limit);

        return $this;
    }

    /**
     * @param  int  $next
     * @return $this
     */
    public function setNext(int $next): self
    {
        $this->setParameter('Next', $next);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums\GroupType  $groupType
     * @return $this
     */
    public function setGroupType(GroupType $groupType): self
    {
        $this->setParameter('GroupType', $groupType->value);

        return $this;
    }
}
