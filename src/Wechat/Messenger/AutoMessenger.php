<?php

namespace Papaedu\Extension\Wechat\Messenger;

use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;
use Papaedu\Extension\Enums\WeChatContentType;
use Papaedu\Extension\Exceptions\InvalidArgumentException;
use Papaedu\Extension\Wechat\Kernel\Messages\Image;
use Papaedu\Extension\Wechat\Kernel\Messages\Message;
use Papaedu\Extension\Wechat\Kernel\Messages\News;
use Papaedu\Extension\Wechat\Kernel\Messages\Text;

class AutoMessenger
{
    /**
     * @var \EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient
     */
    protected AccessTokenAwareClient $client;

    public function __construct(AccessTokenAwareClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param  array  $contents
     * @param  string  $fromUserName
     * @return void
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\RuntimeException
     * @throws \Papaedu\Extension\Exceptions\InvalidArgumentException
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function send(array $contents, string $fromUserName)
    {
        $customerServiceMessenger = new CustomerServiceMessenger($this->client);
        foreach ($contents as $content) {
            $message = $this->formatMessage($content);

            $customerServiceMessenger->message($message)->to($fromUserName)->send();
        }
    }

    public function formatMessage(array $content): Message
    {
        return match ($content['type']) {
            WeChatContentType::TEXT->value => new Text($content['content']),
            WeChatContentType::IMAGE->value => new Image($content['field']),
            WeChatContentType::NEWS->value => new News([
                'title' => $content['content']['title'],
                'description' => $content['content']['desc'],
                'image' => $content['content']['img'],
                'url' => $content['content']['url'],
            ]),
            default => throw new InvalidArgumentException(sprintf('Invalid message type %s.', $content['type'])),
        };
    }
}
