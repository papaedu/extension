<?php

namespace Papaedu\Extension\Wechat\Kernel\Messages;

use JetBrains\PhpStorm\ArrayShape;

class NewsItem extends Message
{
    protected string $type = 'news';

    protected array $properties = [
        'title',
        'description',
        'url',
        'image',
    ];

    #[ArrayShape([
        'title' => "string",
        'description' => "string",
        'url' => "string",
        'picurl' => "string",
    ])]
    public function toJsonArray(): array
    {
        return [
            'title' => $this->get('title'),
            'description' => $this->get('description'),
            'url' => $this->get('url'),
            'picurl' => $this->get('image'),
        ];
    }

    #[ArrayShape([
        'Title' => "string",
        'Description' => "string",
        'Url' => "string",
        'PicUrl' => "string",
    ])]
    public function toXmlArray(): array
    {
        return [
            'Title' => $this->get('title'),
            'Description' => $this->get('description'),
            'Url' => $this->get('url'),
            'PicUrl' => $this->get('image'),
        ];
    }
}
