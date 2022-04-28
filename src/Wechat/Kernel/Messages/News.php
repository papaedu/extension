<?php

namespace Papaedu\Extension\Wechat\Kernel\Messages;

use JetBrains\PhpStorm\ArrayShape;

class News extends Message
{
    protected string $type = 'news';

    protected array $properties = [
        'items',
    ];

    public function __construct(array $items = [])
    {
        parent::__construct(compact('items'));
    }

    #[ArrayShape(['articles' => "array"])]
    public function propertiesToArray(array $data, array $aliases = []): array
    {
        return [
            'articles' => array_map(function ($item) {
                if ($item instanceof NewsItem) {
                    return $item->toJsonArray();
                }
            }, $this->get('items')),
        ];
    }

    #[ArrayShape(['ArticleCount' => "int", 'Articles' => "array"])]
    public function toXmlArray(): array
    {
        $items = [];

        foreach ($this->get('items') as $item) {
            if ($item instanceof NewsItem) {
                $items[] = $item->toXmlArray();
            }
        }

        return [
            'ArticleCount' => count($items),
            'Articles' => $items,
        ];
    }
}
