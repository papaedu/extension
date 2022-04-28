<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums\ApplyJoinOption;
use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\AppDefinedData;
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
    public function setOwnerAccount(string $ownerAccount): self
    {
        $this->setParameter('Owner_Account', $ownerAccount);

        return $this;
    }

    /**
     * @param  string  $type
     * @return $this
     */
    public function setType(string $type): self
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
     * @param  int  $createTime
     * @return $this
     */
    public function setCreateTime(int $createTime): self
    {
        $this->setParameter('CreateTime', $createTime);

        return $this;
    }
}
