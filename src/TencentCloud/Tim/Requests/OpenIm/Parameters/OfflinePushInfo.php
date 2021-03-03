<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

class OfflinePushInfo extends Parameter
{
    /**
     * @param  int  $pushFlag
     */
    public function setPushFlag(int $pushFlag = 0)
    {
        $this->parameters[] = [
            'PushFlag' => $pushFlag,
        ];
    }

    /**
     * @param  string  $title
     */
    public function setTitle(string $title = '')
    {
        $this->parameters[] = [
            'Title' => $title,
        ];
    }

    /**
     * @param  string  $desc
     */
    public function setDesc(string $desc = '')
    {
        $this->parameters[] = [
            'Desc' => $desc,
        ];
    }

    /**
     * @param  string  $ext
     */
    public function setExt(string $ext = '')
    {
        $this->parameters[] = [
            'Ext' => $ext,
        ];
    }

    /**
     * @param  string  $sound
     * @param  array  $channelId
     */
    public function setAndroidInfo(string $sound = '', array $channelId = [])
    {
        $this->parameters[] = [
            "AndroidInfo" => ['sound' => $sound] + $channelId,
        ];
    }

    /**
     * @param  string  $sound
     * @param  int  $badgeMode
     * @param  string  $title
     * @param  string  $subTitle
     * @param  string  $imageUrl
     */
    public function setApnsInfo(
        string $sound = '',
        int $badgeMode = 0,
        string $title = '',
        string $subTitle = '',
        string $imageUrl = ''
    ) {
        $this->parameters[] = [
            "ApnsInfo" => [
                "Sound" => $sound,
                "BadgeMode" => $badgeMode,
                "Title" => $title,
                "SubTitle" => $subTitle,
                "Image" => $imageUrl,
            ],
        ];
    }
}
