<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class SendGroupSystemNotificationRequest extends TimRequest
{
    /**
     * SendGroupSystemNotificationRequest constructor.
     *
     * @param  string  $groupId
     * @param  string  $content
     */
    public function __construct(string $groupId, string $content)
    {
        $this->setGroupId($groupId)
            ->setContent($content);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/send_group_system_notification';
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
     * @param  array  $toMembersAccount
     * @return $this
     */
    public function setToMembersAccount(array $toMembersAccount): self
    {
        $this->setParameter('ToMembers_Account', $toMembersAccount);

        return $this;
    }

    /**
     * @param  string  $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->setParameter('Content', $content);

        return $this;
    }
}
