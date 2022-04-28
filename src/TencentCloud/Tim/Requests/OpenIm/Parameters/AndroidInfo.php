<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class AndroidInfo extends Parameter
{
    /**
     * @param  string  $sound
     * @return $this
     */
    public function setSound(string $sound): static
    {
        $this->setParameter('Sound', $sound);

        return $this;
    }

    /**
     * @param  string  $huaWeiChannelId
     * @return $this
     */
    public function setHuaWeiChannelId(string $huaWeiChannelId): static
    {
        $this->setParameter('HuaWeiChannelID', $huaWeiChannelId);

        return $this;
    }

    /**
     * @param  string  $xiaoMiChannelId
     * @return $this
     */
    public function setXiaoMiChannelId(string $xiaoMiChannelId): static
    {
        $this->setParameter('XiaoMiChannelID', $xiaoMiChannelId);

        return $this;
    }

    /**
     * @param  string  $oppoChannelId
     * @return $this
     */
    public function setOppoChannelId(string $oppoChannelId): static
    {
        $this->setParameter('OPPOChannelID', $oppoChannelId);

        return $this;
    }

    /**
     * @param  string  $googleChannelId
     * @return $this
     */
    public function setGoogleChannelId(string $googleChannelId): static
    {
        $this->setParameter('GoogleChannelID', $googleChannelId);

        return $this;
    }
}
