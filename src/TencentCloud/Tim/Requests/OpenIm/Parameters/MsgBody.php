<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Parameters;

use Papaedu\Extension\TencentCloud\Kernel\Parameter;

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
            'MsgType' => 'TIMTextElem',
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
            'MsgType' => 'TIMLocationElem',
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
            'MsgType' => 'TIMFaceElem',
            'MsgContent' => [
                'Index' => $index,
                'Data' => $data,
            ],
        ];
    }

    public function setCustomMsg(string $data, string $desc, string $ext, string $sound)
    {
        $this->parameters[] = [
            'MsgType' => 'TIMCustomElem',
            'MsgContent' => [
                'Data' => $data,
                'Desc' => $desc,
                'Ext' => $ext,
                'Sound' => $sound,
            ],
        ];
    }

    public function setSoundMsg(string $url, int $size, int $second, int $downloadFlag)
    {
        $this->parameters[] = [
            'MsgType' => 'TIMSoundElem',
            'MsgContent' => [
                'Url' => $url,
                'Size' => $size,
                'Second' => $second,
                'Download_Flag' => $downloadFlag,
            ],
        ];
    }

    public function setImageElem(string $uuid, int $imageFormat, ImageInfoArray $imageInfoArray)
    {
        $this->parameters[] = [
            'MsgType' => 'TIMImageElem',
            'MsgContent' => [
                'UUID' => $uuid,
                'ImageFormat' => $imageFormat,
                'ImageInfoArray' => $imageInfoArray->getParameters(),
            ],
        ];
    }

    public function setFileMsg(string $url, int $filesize, string $filename, int $downloadFlag)
    {
        $this->parameters[] = [
            'MsgType' => 'TIMFileElem',
            'MsgContent' => [
                'Url' => $url,
                'FileSize' => $filesize,
                'FileName' => $filename,
                'Download_Flag' => $downloadFlag,
            ],
        ];
    }

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
            'MsgType' => 'TIMVideoFileElem',
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
