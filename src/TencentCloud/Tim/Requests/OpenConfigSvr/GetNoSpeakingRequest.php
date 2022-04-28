<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenConfigSvr;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class GetNoSpeakingRequest extends TimRequest
{
    /**
     * GetNoSpeakingRequest constructor.
     *
     * @param  string  $getAccount
     */
    public function __construct(string $getAccount)
    {
        $this->setGetAccount($getAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openconfigsvr/getnospeaking';
    }

    /**
     * @param  string  $getAccount
     * @return $this
     */
    public function setGetAccount(string $getAccount): self
    {
        $this->setParameter('Get_Account', $getAccount);

        return $this;
    }
}
