<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Profile\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class ProfileItem extends Parameter
{
    /**
     * ProfileItem constructor.
     *
     * @param  string  $tag
     * @param  string  $value
     */
    public function __construct(string $tag, string $value)
    {
        $this->setTag($tag)->setValue($value);
    }

    /**
     * @param  string  $tag
     * @return $this
     */
    public function setTag(string $tag): ProfileItem
    {
        $this->setParameter('Tag', $tag);

        return $this;
    }

    /**
     * @param  string  $value
     * @return $this
     */
    public function setValue(string $value): ProfileItem
    {
        $this->setParameter('Value', $value);

        return $this;
    }
}
