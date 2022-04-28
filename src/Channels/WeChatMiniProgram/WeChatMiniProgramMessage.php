<?php

namespace Papaedu\Extension\Channels\WeChatMiniProgram;

class WeChatMiniProgramMessage
{
    /**
     * @var string
     */
    private string $channel = '';

    /**
     * @var string
     */
    private string $toUser = '';

    /**
     * @var string
     */
    private string $templateId = '';

    /**
     * @var string
     */
    private string $page = '';

    /**
     * @var array
     */
    private array $data = [];

    /**
     * @var string
     */
    private string $miniProgramState = '';

    /**
     * @var string
     */
    private string $lang = '';

    /**
     * @param  string  $channel
     * @return $this
     */
    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @param  string  $toUser
     * @return $this
     */
    public function setToUser(string $toUser): self
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * @param  string  $templateId
     * @return $this
     */
    public function setTemplateId(string $templateId): self
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * @param  string  $page
     * @return $this
     */
    public function setPage(string $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param  array  $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param  string  $miniProgramState
     * @return $this
     */
    public function setMiniProgramState(string $miniProgramState): self
    {
        $this->miniProgramState = $miniProgramState;

        return $this;
    }

    /**
     * @param  string  $lang
     * @return $this
     */
    public function setLang(string $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return string
     */
    public function getChannel(): string
    {
        return $this->channel;
    }

    /**
     * @return array
     */
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
