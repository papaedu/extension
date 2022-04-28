<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetRoleInGroupRequest extends TimRequest
{
    /**
     * GetRoleInGroupRequest constructor.
     *
     * @param  string  $groupId
     * @param  array  $userAccount
     */
    public function __construct(string $groupId, array $userAccount)
    {
        $this->setGroupId($groupId)
            ->setUserAccount($userAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/get_role_in_group';
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
     * @param  array  $userAccount
     * @return $this
     */
    public function setUserAccount(array $userAccount): self
    {
        $this->setParameter('User_Account', $userAccount);

        return $this;
    }
}
