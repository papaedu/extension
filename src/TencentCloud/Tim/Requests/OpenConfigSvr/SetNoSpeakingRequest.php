<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenConfigSvr;

use Papaedu\Extension\TencentCloud\Tim\Requests\TimRequest;

class SetNoSpeakingRequest extends TimRequest
{
    /**
     * SetNoSpeakingRequest constructor.
     *
     * @param  string  $setAccount
     */
    public function __construct(string $setAccount)
    {
        $this->setSetAccount($setAccount);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return 'v4/openconfigsvr/setnospeaking';
    }

    /**
     * @param  string  $setAccount
     * @return $this
     */
    public function setSetAccount(string $setAccount): self
    {
        $this->setParameter('Set_Account', $setAccount);

        return $this;
    }

    /**
     * @param  int  $c2CMsgSpeakingTime
     * @return $this
     */
    public function setC2CMsgSpeakingTime(int $c2CMsgSpeakingTime): self
    {
        $this->setParameter('C2CmsgNospeakingTime', $c2CMsgSpeakingTime);

        return $this;
    }

    /**
     * @param  int  $groupMsgNoSpeakingTime
     * @return $this
     */
    public function setGroupMsgNoSpeakingTime(int $groupMsgNoSpeakingTime): self
    {
        $this->setParameter('GroupmsgNospeakingTime', $groupMsgNoSpeakingTime);

        return $this;
    }
}
