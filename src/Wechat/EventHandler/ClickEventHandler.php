<?php

namespace Papaedu\Extension\Wechat\EventHandler;

use EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient;
use Papaedu\Extension\Wechat\Kernel\Contracts\ContentInterface;
use Papaedu\Extension\Wechat\Messenger\AutoMessenger;

class ClickEventHandler
{
    /**
     * @var \EasyWeChat\Kernel\HttpClient\AccessTokenAwareClient
     */
    protected AccessTokenAwareClient $client;

    /**
     * @var \Papaedu\Extension\Wechat\Kernel\Contracts\ContentInterface
     */
    protected ContentInterface $content;

    public function __construct(AccessTokenAwareClient $client, ContentInterface $content)
    {
        $this->content = $content;
        $this->client = $client;
    }

    public function __invoke($message, \Closure $next)
    {
        if ($message->MsgType !== 'event' || $message->Event !== 'CLICK') {
            return $next($message);
        }

        $this->handle($message);

        return '';
    }

    public function handle($message): void
    {
        $autoMessenger = new AutoMessenger($this->client);
        $autoMessenger->send($this->content->getContents($message), $message['FromUserName']);
    }
}
