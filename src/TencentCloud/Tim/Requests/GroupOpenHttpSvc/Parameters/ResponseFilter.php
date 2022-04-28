<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class ResponseFilter extends Parameter
{
    /**
     * @param  array  $groupBaseInfoFilter
     * @return $this
     */
    public function setGroupBaseInfoFilter(array $groupBaseInfoFilter): self
    {
        $this->setParameter('GroupBaseInfoFilter', $groupBaseInfoFilter);

        return $this;
    }

    /**
     * @param  array  $memberInfoFilter
     * @return $this
     */
    public function setMemberInfoFilter(array $memberInfoFilter): self
    {
        $this->setParameter('MemberInfoFilter', $memberInfoFilter);

        return $this;
    }

    /**
     * @param  array  $selfInfoFilter
     * @return $this
     */
    public function setSelfInfoFilter(array $selfInfoFilter): self
    {
        $this->setParameter('SelfInfoFilter', $selfInfoFilter);

        return $this;
    }

    /**
     * @param  array  $appDefinedDataFilterGroup
     * @return $this
     */
    public function setAppDefinedDataFilterGroup(array $appDefinedDataFilterGroup): self
    {
        $this->setParameter('AppDefinedDataFilter_Group', $appDefinedDataFilterGroup);

        return $this;
    }

    /**
     * @param  array  $appDefinedDataFilterGroupMember
     * @return $this
     */
    public function setAppDefinedDataFilterGroupMember(array $appDefinedDataFilterGroupMember): self
    {
        $this->setParameter('AppDefinedDataFilter_GroupMember', $appDefinedDataFilterGroupMember);

        return $this;
    }
}
