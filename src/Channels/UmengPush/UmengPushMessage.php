<?php

namespace Papaedu\Extension\Channels\UmengPush;

class UmengPushMessage
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $content;

    /**
     * @var array
     */
    public $clientField = [];

    /**
     * @var string
     */
    public $afterOpen;

    /**
     * @param  string  $title
     * @return $this
     */
    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param  string  $content
     * @return $this
     */
    public function content(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param  array  $clientField
     * @return $this
     */
    public function clientField(array $clientField)
    {
        $this->clientField = $clientField;

        return $this;
    }

    /**
     * @param  string  $afterOpen
     * @return $this
     */
    public function afterOpen(string $afterOpen)
    {
        $this->afterOpen = $afterOpen;

        return $this;
    }

    /**
     * @return array
     */
    public function toPredefinedForIOS()
    {
        return [
            'alert' => [
                'title' => $this->title,
                'subtitle' => '',
                'body' => $this->content,
            ],
            'badge' => 1,
            'description' => $this->content,
        ];
    }

    /**
     * @return array
     */
    public function toPredefinedForAndroid()
    {
        return [
            'ticker' => 'ticker',
            'title' => $this->title,
            'text' => $this->content,
            'after_open' => $this->afterOpen,
            'description' => $this->content,
        ];
    }

    /**
     * @return array
     */
    public function toClientField()
    {
        return $this->clientField;
    }
}