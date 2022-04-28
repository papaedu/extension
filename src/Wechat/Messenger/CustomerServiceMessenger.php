<?php

namespace Papaedu\Extension\Wechat\Messenger;

use EasyWeChat\Kernel\Exceptions\RuntimeException;
use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;
use Papaedu\Extension\Wechat\Kernel\Messages\Message;
use Papaedu\Extension\Wechat\Kernel\Messages\Text;

class CustomerServiceMessenger
{
    protected Message $message;

    protected string $to;

    protected string $account = '';

    /**
     * @var \EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient
     */
    protected AccessTokenAwareClient $client;

    public function __construct(AccessTokenAwareClient $client)
    {
        $this->client = $client;
    }

    public function message(string|Message $message): self
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        $this->message = $message;

        return $this;
    }

    public function from(string $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function to($openid): self
    {
        $this->to = $openid;

        return $this;
    }

    /**
     * @return \EasyWeChat\Kernel\HttpClient\Response|\Symfony\Contracts\HttpClient\ResponseInterface
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function send()
    {
        if (empty($this->message)) {
            throw new RuntimeException('No message to send.');
        }

        $prepends = [
            'touser' => $this->to,
        ];
        if ($this->account) {
            $prepends['customservice'] = ['kf_account' => $this->account];
        }
        $message = $this->message->transformForJsonRequest($prepends);

        return $this->client->postJson('cgi-bin/message/custom/send', $message);
    }

    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return null;
    }
}
