<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums\ApplyJoinOption;
use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums\GroupType;
use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\AppDefinedData;
use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\AppMemberDefinedData;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class CreateGroupRequest extends TimRequest
{
    /**
     * CreateGroupRequest constructor.
     *
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums\GroupType  $type
     * @param  string  $name
     */
    public function __construct(GroupType $type, string $name)
    {
        $this->setType($type)
            ->setName($name);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/group_open_http_svc/create_group';
    }

    /**
     * @param  string  $ownerAccount
     * @return $this
     */
    public function setOwnerAccount(string $ownerAccount): self
    {
        $this->setParameter('Owner_Account', $ownerAccount);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums\GroupType  $type
     * @return $this
     */
    public function setType(GroupType $type): self
    {
        $this->setParameter('Type', $type);

        return $this;
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
     * @param  string  $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->setParameter('Name', $name);

        return $this;
    }

    /**
     * @param  string  $introduction
     * @return $this
     */
    public function setIntroduction(string $introduction): self
    {
        $this->setParameter('Introduction', $introduction);

        return $this;
    }

    /**
     * @param  string  $notification
     * @return $this
     */
    public function setNotification(string $notification): self
    {
        $this->setParameter('Notification', $notification);

        return $this;
    }

    /**
     * @param  string  $faceUrl
     * @return $this
     */
    public function setFaceUrl(string $faceUrl): self
    {
        $this->setParameter('FaceUrl', $faceUrl);

        return $this;
    }

    /**
     * @param  int  $maxMemberCount
     * @return $this
     */
    public function setMaxMemberCount(int $maxMemberCount): self
    {
        $this->setParameter('MaxMemberCount', $maxMemberCount);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums\ApplyJoinOption  $applyJoinOption
     * @return $this
     */
    public function setApplyJoinOption(ApplyJoinOption $applyJoinOption): self
    {
        $this->setParameter('ApplyJoinOption', $applyJoinOption);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\AppDefinedData  $appDefinedData
     * @return $this
     */
    public function setAppDefinedData(AppDefinedData $appDefinedData): self
    {
        $this->setParameter('AppDefinedData', $appDefinedData);

        return $this;
    }

    /**
     * @param  array  $memberList
     * @return $this
     */
    public function setMemberList(array $memberList): self
    {
        $this->setParameter('MemberList', $memberList);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\AppMemberDefinedData  $appMemberDefinedData
     * @return $this
     */
    public function setAppMemberDefinedData(AppMemberDefinedData $appMemberDefinedData): self
    {
        $this->setParameter('AppMemberDefinedData', $appMemberDefinedData);

        return $this;
    }
}
