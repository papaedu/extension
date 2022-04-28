<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class OfflinePushInfo extends Parameter
{
    /**
     * @param  int  $pushFlag
     * @return $this
     */
    public function setPushFlag(int $pushFlag): static
    {
        $this->setParameter('PushFlag', $pushFlag);

        return $this;
    }

    /**
     * @param  string  $title
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->setParameter('Title', $title);

        return $this;
    }

    /**
     * @param  string  $desc
     * @return $this
     */
    public function setDesc(string $desc): static
    {
        $this->setParameter('Desc', $desc);

        return $this;
    }

    /**
     * @param  string  $ext
     * @return $this
     */
    public function setExt(string $ext): static
    {
        $this->setParameter('Ext', $ext);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\AndroidInfo  $androidInfo
     * @return $this
     */
    public function setAndroidInfo(AndroidInfo $androidInfo): static
    {
        $this->setParameter('AndroidInfo', $androidInfo);

        return $this;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\ApnsInfo  $apnsInfo
     * @return $this
     */
    public function setApnsInfo(ApnsInfo $apnsInfo): static
    {
        $this->setParameter('ApnsInfo', $apnsInfo);

        return $this;
    }
}
