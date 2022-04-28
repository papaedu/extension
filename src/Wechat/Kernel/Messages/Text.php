<?php

namespace Papaedu\Extension\Wechat\Kernel\Messages;

use JetBrains\PhpStorm\ArrayShape;

class Text extends Message
{
    protected string $type = 'text';

    protected array $properties = [
        'content',
    ];

    public function __construct(string $content = '')
    {
        parent::__construct(compact('content'));
    }

    #[ArrayShape(['Content' => "string"])]
    public function toXmlArray(): array
    {
        return [
            'Content' => $this->get('content'),
        ];
    }
}
