<?php

namespace Papaedu\Extension\Wechat\Kernel\Messages;

use EasyWeChat\Kernel\Support\Str;
use Papaedu\Extension\Wechat\Kernel\Contracts\MediaInterface;

class Media extends Message implements MediaInterface
{
    protected array $properties = [
        'media_id',
    ];

    protected array $required = [
        'media_id',
    ];

    public function __construct(string $mediaId, $type = null, array $attributes = [])
    {
        parent::__construct(array_merge(['media_id' => $mediaId], $attributes));

        !empty($type) && $this->setType($type);
    }

    /**
     * @return string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function getMediaId(): string
    {
        $this->checkRequiredAttributes();

        return $this->get('media_id');
    }

    public function toXmlArray(): array
    {
        return [
            Str::studly($this->getType()) => [
                'MediaId' => $this->get('media_id'),
            ],
        ];
    }
}
