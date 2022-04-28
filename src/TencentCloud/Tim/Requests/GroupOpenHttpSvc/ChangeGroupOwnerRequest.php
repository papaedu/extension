<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ChangeGroupOwnerRequest extends TimRequest
{
    /**
     * ChangeGroupOwnerRequest constructor.
     *
     * @param  string  $groupId
     * @param  string  $newOwnerAccount
     */
    public function __construct(string $groupId, string $newOwnerAccount)
    {
        $this->setGroupId($groupId)
            ->setNewOwnerAccount($newOwnerAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/change_group_owner';
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
     * @param  string  $newOwnerAccount
     * @return $this
     */
    public function setNewOwnerAccount(string $newOwnerAccount): self
    {
        $this->setParameter('NewOwner_Account', $newOwnerAccount);

        return $this;
    }
}
