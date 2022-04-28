<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class AppMemberDefinedData extends Parameter
{
    /**
     * AppDefinedData constructor.
     *
     * @param  string  $key
     * @param  string  $value
     */
    public function __construct(string $key, string $value)
    {
        $this->setAppDefinedData($key, $value);
    }

    /**
     * @param  string  $key
     * @param  string  $value
     * @return $this
     */
    public function setAppDefinedData(string $key, string $value): self
    {
        $this->parameters[] = [
            'Key' => $key,
            'Value' => $value,
        ];

        return $this;
    }
}
