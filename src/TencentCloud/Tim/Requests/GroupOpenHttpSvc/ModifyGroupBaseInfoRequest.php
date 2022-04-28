<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc;

use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums\ApplyJoinOption;
use Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters\AppDefinedData;
use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ModifyGroupBaseInfoRequest extends TimRequest
{
    /**
     * ModifyGroupBaseInfoRequest constructor.
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
        return 'v4/group_open_http_svc/modify_group_base_info';
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
     * @param  int  $maxMemberNum
     * @return $this
     */
    public function setMaxMemberNum(int $maxMemberNum): self
    {
        $this->setParameter('MaxMemberNum', $maxMemberNum);

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
     * @param  string  $shutUpAllMember
     * @return $this
     */
    public function setShutUpAllMember(string $shutUpAllMember): self
    {
        $this->setParameter('ShutUpAllMember', $shutUpAllMember);

        return $this;
    }
}
