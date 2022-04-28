<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class ImageInfoArray extends Parameter
{
    /**
     * ImageInfoArray constructor.
     *
     * @param  int  $type
     * @param  int  $size
     * @param  int  $width
     * @param  int  $height
     * @param  string  $url
     */
    public function __construct(int $type, int $size, int $width, int $height, string $url)
    {
        $this->setImageInfo($type, $size, $width, $height, $url);
    }

    /**
     * @param  int  $type
     * @param  int  $size
     * @param  int  $width
     * @param  int  $height
     * @param  string  $url
     * @return $this
     */
    public function setImageInfo(int $type, int $size, int $width, int $height, string $url): static
    {
        $this->parameters[] = [
            'type' => $type,
            'size' => $size,
            'width' => $width,
            'height' => $height,
            'url' => $url,
        ];

        return $this;
    }
}
