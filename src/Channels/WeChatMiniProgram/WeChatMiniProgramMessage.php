<?php

namespace Papaedu\Extension\Channels\WeChatMiniProgram;

class WeChatMiniProgramMessage
{
    protected string $channel = '';

    protected string $toUser = '';

    protected string $templateId = '';

    protected string $page = '';

    protected array $data = [];

    protected string $miniProgramState = '';

    protected string $lang = '';

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function setToUser(string $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }

    public function setTemplateId(string $templateId): self
    {
        $this->templateId = $templateId;

        return $this;
    }

    public function setPage(string $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setMiniProgramState(string $miniProgramState): self
    {
        $this->miniProgramState = $miniProgramState;

        return $this;
    }

    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function toSendData(): array
    {
        return array_filter([
            'touser' => $this->toUser,
            'template_id' => $this->templateId,
            'page' => $this->page,
            'data' => $this->data,
            'miniprogram_state' => $this->miniProgramState,
            'lang' => $this->lang,
        ]);
    }
}
