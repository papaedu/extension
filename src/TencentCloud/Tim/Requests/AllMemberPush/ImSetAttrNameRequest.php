<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class ImSetAttrNameRequest extends TimRequest
{
    /**
     * ImSetAttrNameRequest constructor.
     *
     * @param  array  $attrNames
     */
    public function __construct(array $attrNames)
    {
        $this->setAttrNames($attrNames);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/all_member_push/im_set_attr_name';
    }

    /**
     * @param  array  $attrNames
     * @return \Papaedu\Extension\TencentCloud\Tim\Requests\AllMemberPush\ImSetAttrNameRequest
     */
    public function setAttrNames(array $attrNames): self
    {
        $attrNamesArray = [];
        $index = 0;
        foreach ($attrNames as $attrName) {
            $attrNamesArray[$index] = $attrName;
            $index++;
        }

        $this->setParameter('AttrNames', $attrNamesArray);

        return $this;
    }
}
