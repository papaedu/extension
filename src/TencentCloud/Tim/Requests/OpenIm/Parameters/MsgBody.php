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
                "Desc" => $desc,
                "Latitude" => $latitude,
                "Longitude" => $longitude,
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
                "Index" => $index,
                "Data" => $data,
            ],
        ];
    }
}
