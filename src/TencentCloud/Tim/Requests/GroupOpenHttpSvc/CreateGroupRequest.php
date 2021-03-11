<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class CreateGroupRequest extends TimRequest
{
    /**
     * CreateGroupRequest constructor.
     *
     * @param  string  $type
     * @param  string  $name
     */
    public function __construct(string $type, string $name)
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
    public function setOwnerAccount(string $ownerAccount): CreateGroupRequest
    {
        $this->setParameter('Owner_Account', $ownerAccount);

        return $this;
    }

    /**
     * @param  string  $type
     * @return $this
     */
    public function setType(string $type): CreateGroupRequest
    {
        $this->setParameter('Type', $type);

        return $this;
    }

    /**
     * @param  string  $groupId
     * @return $this
     */
    public function setGroupId(string $groupId): CreateGroupRequest
    {
        $this->setParameter('GroupId', $groupId);

        return $this;
    }

    /**
     * @param  string  $name
     * @return $this
     */
    public function setName(string $name): CreateGroupRequest
    {
        $this->setParameter('Name', $name);

        return $this;
    }

    /**
     * @param  string  $introduction
     * @return $this
     */
    public function setIntroduction(string $introduction): CreateGroupRequest
    {
        $this->setParameter('Introduction', $introduction);

        return $this;
    }

    /**
     * @param  string  $notification
     * @return $this
     */
    public function setNotification(string $notification): CreateGroupRequest
    {
        $this->setParameter('Notification', $notification);

        return $this;
    }

    /**
     * @param  string  $faceUrl
     * @return $this
     */
    public function setFaceUrl(string $faceUrl): CreateGroupRequest
    {
        $this->setParameter('FaceUrl', $faceUrl);

        return $this;
    }

    /**
     * @param  int  $maxMemberCount
     * @return $this
     */
    public function setMaxMemberCount(int $maxMemberCount): CreateGroupRequest
    {
        $this->setParameter('MaxMemberCount', $maxMemberCount);

        return $this;
    }

    /**
     * @param  string  $applyJoinOption
     * @return $this
     */
    public function setApplyJoinOption(string $applyJoinOption): CreateGroupRequest
    {
        $this->setParameter('ApplyJoinOption', $applyJoinOption);

        return $this;
    }

    /**
     * @param  array  $appDefinedData
     * @return $this
     */
    public function setAppDefinedData(array $appDefinedData): CreateGroupRequest
    {
        $this->setParameter('AppDefinedData', $appDefinedData);

        return $this;
    }

    /**
     * @param  array  $memberList
     * @return $this
     */
    public function setMemberList(array $memberList): CreateGroupRequest
    {
        $this->setParameter('MemberList', $memberList);

        return $this;
    }

    /**
     * @param  array  $appMemberDefinedData
     * @return $this
     */
    public function setAppMemberDefinedData(array $appMemberDefinedData): CreateGroupRequest
    {
        $this->setParameter('AppMemberDefinedData', $appMemberDefinedData);

        return $this;
    }
}
