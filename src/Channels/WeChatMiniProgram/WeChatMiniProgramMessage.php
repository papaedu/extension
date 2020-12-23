<?php

namespace Papaedu\Extension\Channels\WeChatMiniProgram;

class WeChatMiniProgramMessage
{
    /**
     * @var string
     */
    private string $channel;

    /**
     * @var string
     */
    private string $toUser;

    /**
     * @var string
     */
    private string $templateId;

    /**
     * @var string
     */
    private string $page;

    /**
     * @var string
     */
    private string $formId;

    /**
     * @var array
     */
    private array $data;

    /**
     * @var string
     */
    private string $emphasisKeyword;

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
     * @param  string  $formId
     * @return $this
     */
    public function setFormId(string $formId): self
    {
        $this->formId = $formId;

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
     * @param  string  $emphasisKeyword
     * @return $this
     */
    public function setEmphasisKeyword(string $emphasisKeyword): self
    {
        $this->emphasisKeyword = $emphasisKeyword;

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
        return [
            'touser' => $this->toUser,
            'weapp_template_msg' => [
                'template_id' => $this->templateId,
                'page' => $this->page,
                'form_id' => $this->formId,
                'data' => $this->data,
                'emphasis_keyword' => $this->emphasisKeyword,
            ],
        ];
    }
}
