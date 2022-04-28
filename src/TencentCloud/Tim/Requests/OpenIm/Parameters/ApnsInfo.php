<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class ApnsInfo extends Parameter
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
     * @param  int  $badgeMode
     * @return $this
     */
    public function setBadgeMode(int $badgeMode): static
    {
        $this->setParameter('BadgeMode', $badgeMode);

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
     * @param  string  $subTitle
     * @return $this
     */
    public function setSubTitle(string $subTitle): static
    {
        $this->setParameter('SubTitle', $subTitle);

        return $this;
    }

    /**
     * @param  string  $image
     * @return $this
     */
    public function setImage(string $image): static
    {
        $this->setParameter('Image', $image);

        return $this;
    }
}
