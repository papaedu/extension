<?php

namespace Papaedu\Extension\Channels\UmengPush;

class UmengPushMessage
{
    /**
     * @var string
     */
    private string $title = '';

    /**
     * @var string
     */
    private string $content;

    /**
     * @var array
     */
    private array $clientField = [];

    /**
     * @var string
     */
    private string $afterOpen;

    /**
     * @param  string  $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param  string  $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param  array  $clientField
     * @return $this
     */
    public function setClientField(array $clientField): self
    {
        $this->clientField = $clientField;

        return $this;
    }

    /**
     * @param  string  $afterOpen
     * @return $this
     */
    public function setAfterOpen(string $afterOpen): self
    {
        $this->afterOpen = $afterOpen;

        return $this;
    }

    /**
     * @return array
     */
    public function getPredefinedForIOS(): array
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
    public function getPredefinedForAndroid(): array
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
    public function getClientField(): array
    {
        return $this->clientField;
    }
}
