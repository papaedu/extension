<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenConfigSvr;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetAppInfoRequest extends TimRequest
{
    /**
     * GetAppInfoRequest constructor.
     *
     * @param  array  $requestField
     */
    public function __construct(array $requestField)
    {
        $this->setRequestField($requestField);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openconfigsvr/getappinfo';
    }

    /**
     * @param  array  $requestField
     * @return $this
     */
    public function setRequestField(array $requestField): self
    {
        $this->setParameter('RequestField', $requestField);

        return $this;
    }
}
