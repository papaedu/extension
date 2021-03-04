<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class SnsItem extends Parameter
{
    /**
     * SnsItem constructor.
     *
     * @param  string  $tag
     * @param $value
     */
    public function __construct(string $tag, $value)
    {
        $this->setTag($tag)->setValue($value);
    }

    /**
     * @param  string  $tag
     * @return $this
     */
    public function setTag(string $tag): SnsItem
    {
        $this->setParameter('Tag', $tag);

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value): SnsItem
    {
        $this->setParameter('Value', $value);

        return $this;
    }
}
