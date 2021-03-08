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
        $this->setTagAndValue($tag, $value);
    }

    /**
     * @param  string  $tag
     * @param  string  $value
     * @return $this
     */
    public function setTagAndValue(string $tag, string $value): ProfileItem
    {
        $this->parameters[] = [
            'Tag' => $tag,
            'Value' => $value,
        ];

        return $this;
    }
}
