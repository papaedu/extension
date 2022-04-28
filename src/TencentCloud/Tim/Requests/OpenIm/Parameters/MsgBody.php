<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;
use Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums\MsgType;

class MsgBody extends Parameter
{
    /**
     * MsgBody constructor.
     *
     * @param  string  $text
     */
    public function __construct(string $text = '')
    {
        if ($text) {
            $this->setTextMsg($text);
        }
    }

    /**
     * @param  string  $text
     */
    public function setTextMsg(string $text)
    {
        $this->parameters[] = [
            'MsgType' => MsgType::TEXT->value,
            'MsgContent' => [
                'Text' => $text,
            ],
        ];
    }

    /**
     * @param  string  $desc
     * @param  string  $latitude
     * @param  string  $longitude
     */
    public function setLocationMsg(string $desc, string $latitude, string $longitude)
    {
        $this->parameters[] = [
            'MsgType' => MsgType::LOCATION->value,
            'MsgContent' => [
                'Desc' => $desc,
                'Latitude' => $latitude,
                'Longitude' => $longitude,
            ],
        ];
    }

    /**
     * @param  int  $index
     * @param  string  $data
     */
    public function setFaceMsg(int $index, string $data)
    {
        $this->parameters[] = [
            'MsgType' => MsgType::FACE->value,
            'MsgContent' => [
                'Index' => $index,
                'Data' => $data,
            ],
        ];
    }

    /**
     * @param  array  $data
     * @param  string  $desc
     * @param  string  $ext
     * @param  string  $sound
     */
    public function setCustomMsg(array $data, string $desc = '', string $ext = '', string $sound = '')
    {
        $this->parameters[] = [
            'MsgType' => MsgType::CUSTOM->value,
            'MsgContent' => [
                'Data' => json_encode($data),
                'Desc' => $desc,
                'Ext' => $ext,
                'Sound' => $sound,
            ],
        ];
    }

    /**
     * @param  string  $url
     * @param  int  $size
     * @param  int  $second
     * @param  int  $downloadFlag
     */
    public function setSoundMsg(string $url, int $size, int $second, int $downloadFlag)
    {
        $this->parameters[] = [
            'MsgType' => MsgType::SOUND->value,
            'MsgContent' => [
                'Url' => $url,
                'Size' => $size,
                'Second' => $second,
                'Download_Flag' => $downloadFlag,
            ],
        ];
    }

    /**
     * @param  string  $uuid
     * @param  int  $imageFormat
     * @param  \Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters\ImageInfoArray  $imageInfoArray
     */
    public function setImageElem(string $uuid, int $imageFormat, ImageInfoArray $imageInfoArray)
    {
        $this->parameters[] = [
            'MsgType' => MsgType::IMAGE->value,
            'MsgContent' => [
                'UUID' => $uuid,
                'ImageFormat' => $imageFormat,
                'ImageInfoArray' => $imageInfoArray->getParameters(),
            ],
        ];
    }

    /**
     * @param  string  $url
     * @param  int  $filesize
     * @param  string  $filename
     * @param  int  $downloadFlag
     */
    public function setFileMsg(string $url, int $filesize, string $filename, int $downloadFlag)
    {
        $this->parameters[] = [
            'MsgType' => MsgType::FILE->value,
            'MsgContent' => [
                'Url' => $url,
                'FileSize' => $filesize,
                'FileName' => $filename,
                'Download_Flag' => $downloadFlag,
            ],
        ];
    }

    /**
     * @param  string  $videoUrl
     * @param  int  $videoSize
     * @param  int  $videoSecond
     * @param  string  $videoFormat
     * @param  int  $videoDownloadFlag
     * @param  string  $thumbUrl
     * @param  int  $thumbSize
     * @param  int  $thumbWidth
     * @param  int  $thumbHeight
     * @param  string  $thumbFormat
     * @param  int  $thumbDownloadFlag
     */
    public function setVideoMsg(
        string $videoUrl,
        int $videoSize,
        int $videoSecond,
        string $videoFormat,
        int $videoDownloadFlag,
        string $thumbUrl,
        int $thumbSize,
        int $thumbWidth,
        int $thumbHeight,
        string $thumbFormat,
        int $thumbDownloadFlag
    ) {
        $this->parameters[] = [
            'MsgType' => MsgType::VIDEO_FILE->value,
            'MsgContent' => [
                'VideoUrl' => $videoUrl,
                'VideoSize' => $videoSize,
                'VideoSecond' => $videoSecond,
                'VideoFormat' => $videoFormat,
                'VideoDownloadFlag' => $videoDownloadFlag,
                'ThumbUrl' => $thumbUrl,
                'ThumbSize' => $thumbSize,
                'ThumbWidth' => $thumbWidth,
                'ThumbHeight' => $thumbHeight,
                'ThumbFormat' => $thumbFormat,
                'ThumbDownloadFlag' => $thumbDownloadFlag,
            ],
        ];
    }
}
