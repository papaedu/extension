<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Parameters;

use BackedEnum;
use Papaedu\Extension\TencentCloud\Kernel\Parameter;
use UnitEnum;

class AppDefinedData extends Parameter
{
    /**
     * AppDefinedData constructor.
     *
     * @param  string  $key
     * @param  BackedEnum|UnitEnum|string  $value
     */
    public function __construct(string $key, BackedEnum|UnitEnum|string $value)
    {
        $this->setAppDefinedData($key, $value);
    }

    /**
     * @param  string  $key
     * @param  BackedEnum|UnitEnum|string  $value
     * @return $this
     */
    public function setAppDefinedData(string $key, BackedEnum|UnitEnum|string $value): self
    {
        if ($value instanceof BackedEnum) {
            $value = $value->value;
        } elseif ($value instanceof UnitEnum) {
            $value = $value->name;
        }

        $this->parameters[] = [
            'Key' => $key,
            'Value' => $value,
        ];

        return $this;
    }
}
