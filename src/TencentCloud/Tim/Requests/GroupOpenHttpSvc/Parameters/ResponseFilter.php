<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class ResponseFilter extends Parameter
{
    /**
     * @param  array  $groupBaseInfoFilter
     * @return $this
     */
    public function setGroupBaseInfoFilter(array $groupBaseInfoFilter): ResponseFilter
    {
        $this->setParameter('GroupBaseInfoFilter', $groupBaseInfoFilter);

        return $this;
    }

    /**
     * @param  array  $memberInfoFilter
     * @return $this
     */
    public function setMemberInfoFilter(array $memberInfoFilter): ResponseFilter
    {
        $this->setParameter('MemberInfoFilter', $memberInfoFilter);

        return $this;
    }

    /**
     * @param  array  $appDefinedDataFilterGroup
     * @return $this
     */
    public function setAppDefinedDataFilterGroup(array $appDefinedDataFilterGroup): ResponseFilter
    {
        $this->setParameter('AppDefinedData', $appDefinedDataFilterGroup);

        return $this;
    }

    /**
     * @param  array  $appDefinedDataFilterGroupMember
     * @return $this
     */
    public function setAppDefinedDataFilterGroupMember(array $appDefinedDataFilterGroupMember): ResponseFilter
    {
        $this->setParameter('AppDefinedDataFilterGroupMember', $appDefinedDataFilterGroupMember);

        return $this;
    }
}
