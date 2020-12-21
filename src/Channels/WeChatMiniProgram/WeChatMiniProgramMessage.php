<?php

namespace Papaedu\Extension\Channels\WeChatMiniProgram;

class WeChatMiniProgramMessage
{
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
    private string $fromId;

    /**
     * @var array
     */
    private array $data;

    /**
     * @var string
     */
    private string $emphasisKeyword;

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
     * @param  string  $fromId
     * @return $this
     */
    public function setFromId(string $fromId): self
    {
        $this->fromId = $fromId;

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
     * @return array
     */
    public function toSendData(): array
    {
        return [
            'touser' => $this->toUser,
            'template_id' => $this->templateId,
            'page' => $this->page,
            'from_id' => $this->fromId,
            'data' => $this->data,
            'emphasis_keyword' => $this->emphasisKeyword,
        ];
    }
}
