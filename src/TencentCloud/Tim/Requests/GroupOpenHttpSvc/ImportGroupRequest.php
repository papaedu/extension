<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImportGroupRequest extends TimRequest
{
    /**
     * ImportGroupRequest constructor.
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
        return 'v4/group_open_http_svc/import_group';
    }

    /**
     * @param  string  $ownerAccount
     * @return $this
     */
    public function setOwnerAccount(string $ownerAccount): ImportGroupRequest
    {
        $this->setParameter('Owner_Account', $ownerAccount);

        return $this;
    }

    /**
     * @param  string  $type
     * @return $this
     */
    public function setType(string $type): ImportGroupRequest
    {
        $this->setParameter('Type', $type);

        return $this;
    }

    /**
     * @param  string  $groupId
     * @return $this
     */
    public function setGroupId(string $groupId): ImportGroupRequest
    {
        $this->setParameter('GroupId', $groupId);

        return $this;
    }

    /**
     * @param  string  $name
     * @return $this
     */
    public function setName(string $name): ImportGroupRequest
    {
        $this->setParameter('Name', $name);

        return $this;
    }

    /**
     * @param  string  $introduction
     * @return $this
     */
    public function setIntroduction(string $introduction): ImportGroupRequest
    {
        $this->setParameter('Introduction', $introduction);

        return $this;
    }

    /**
     * @param  string  $notification
     * @return $this
     */
    public function setNotification(string $notification): ImportGroupRequest
    {
        $this->setParameter('Notification', $notification);

        return $this;
    }

    /**
     * @param  string  $faceUrl
     * @return $this
     */
    public function setFaceUrl(string $faceUrl): ImportGroupRequest
    {
        $this->setParameter('FaceUrl', $faceUrl);

        return $this;
    }

    /**
     * @param  int  $maxMemberCount
     * @return $this
     */
    public function setMaxMemberCount(int $maxMemberCount): ImportGroupRequest
    {
        $this->setParameter('MaxMemberCount', $maxMemberCount);

        return $this;
    }

    /**
     * @param  string  $applyJoinOption
     * @return $this
     */
    public function setApplyJoinOption(string $applyJoinOption): ImportGroupRequest
    {
        $this->setParameter('ApplyJoinOption', $applyJoinOption);

        return $this;
    }

    /**
     * @param  array  $appDefinedDAta
     * @return $this
     */
    public function setAppDefinedData(array $appDefinedDAta): ImportGroupRequest
    {
        $this->setParameter('AppDefinedData', $appDefinedDAta);

        return $this;
    }

    /**
     * @param  int  $createTime
     * @return $this
     */
    public function setCreateTime(int $createTime): ImportGroupRequest
    {
        $this->setParameter('CreateTime', $createTime);

        return $this;
    }
}
