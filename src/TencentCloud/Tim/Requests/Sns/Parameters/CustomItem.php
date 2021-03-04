<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class CustomItem extends Parameter
{
    /**
     * @param  string  $tag
     * @return $this
     */
    public function setTag(string $tag): CustomItem
    {
        $this->setParameter('Tag', $tag);

        return $this;
    }

    /**
     * @param  string  $value
     * @return $this
     */
    public function setValue(string $value): CustomItem
    {
        $this->setParameter('Value', $value);

        return $this;
    }
}
