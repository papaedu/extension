<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetGroupShuttedUinRequest extends TimRequest
{
    /**
     * GetGroupShuttedUinRequest constructor.
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
        return 'v4/group_open_http_svc/get_group_shutted_uin';
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
}
