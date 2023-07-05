<?php

namespace Papaedu\Extension\Channels\UmengPush;

class UmengPushMessage
{
    protected string $title = '';

    protected string $content = '';

    protected array $customField = [];

    protected string $afterOpen = '';

    protected string $activity = '';

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setCustomField(array $customField): self
    {
        $this->customField = $customField;

        return $this;
    }

    public function setAfterOpen(string $afterOpen): self
    {
        $this->afterOpen = $afterOpen;

        return $this;
    }

    public function setActivity(string $activity): self
    {
        $this->activity = $activity;

        return $this;
    }

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

    public function getPredefinedForAndroid(): array
    {
        return [
            'ticker' => 'ticker',
            'title' => $this->title,
            'text' => $this->content,
            'after_open' => $this->afterOpen,
            'activity' => $this->activity,
            'description' => $this->content,
        ];
    }

    public function getCustomField(): array
    {
        return $this->customField;
    }
}
