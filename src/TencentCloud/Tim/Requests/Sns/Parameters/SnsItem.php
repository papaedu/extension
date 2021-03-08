<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\Sns\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class SnsItem extends Parameter
{
    /**
     * ProfileItem constructor.
     *
     * @param  string  $tag
     * @param  mixed  $value
     */
    public function __construct(string $tag, $value)
    {
        $this->setTagAndValue($tag, $value);
    }

    /**
     * @param  string  $tag
     * @param  mixed  $value
     * @return $this
     */
    public function setTagAndValue(string $tag, $value): SnsItem
    {
        $this->parameters[] = [
            'Tag' => $tag,
            'Value' => $value,
        ];

        return $this;
    }
}
