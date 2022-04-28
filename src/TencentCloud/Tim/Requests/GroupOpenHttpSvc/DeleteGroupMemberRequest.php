<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class DeleteGroupMemberRequest extends TimRequest
{
    /**
     * DeleteGroupMemberRequest constructor.
     *
     * @param  string  $groupId
     * @param  array  $memberToDelAccount
     */
    public function __construct(string $groupId, array $memberToDelAccount)
    {
        $this->setGroupId($groupId)
            ->setMemberToDelAccount($memberToDelAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/delete_group_member';
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
     * @param  string  $reason
     * @return $this
     */
    public function setReason(string $reason): self
    {
        $this->setParameter('Reason', $reason);

        return $this;
    }

    /**
     * @param  array  $memberToDelAccount
     * @return $this
     */
    public function setMemberToDelAccount(array $memberToDelAccount): self
    {
        $this->setParameter('MemberToDel_Account', $memberToDelAccount);

        return $this;
    }
}
