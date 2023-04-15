<?php

namespace Papaedu\Extension\Support;

use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\ArrayShape;

class FeishuGroupBot
{
    private const HOOK_URL = 'https://open.feishu.cn/open-apis/bot/v2/hook/';

    protected string $hookUrl;

    protected string $secret;

    public function __construct(string $hook, string $secret)
    {
        $this->hookUrl = self::HOOK_URL.$hook;;
        $this->secret = $secret;
    }

    public function info(string $message, string $headerTitle = '通知'): HttpResponse
    {
        $sign = $this->getSign();

        return Http::post($this->hookUrl, [
            'timestamp' => $sign['timestamp'],
            'sign' => $sign['sign'],
            'msg_type' => 'interactive',
            'card' => $this->getCard($message, $headerTitle, 'blue'),
        ]);
    }

    public function warning(string $message, string $headerTitle = '警告'): HttpResponse
    {
        $sign = $this->getSign();

        return Http::post($this->hookUrl, [
            'timestamp' => $sign['timestamp'],
            'sign' => $sign['sign'],
            'msg_type' => 'interactive',
            'card' => $this->getCard($message, $headerTitle, 'yellow'),
        ]);
    }

    public function error(string $message, string $headerTitle = '异常'): HttpResponse
    {
        $sign = $this->getSign();

        return Http::post($this->hookUrl, [
            'timestamp' => $sign['timestamp'],
            'sign' => $sign['sign'],
            'msg_type' => 'interactive',
            'card' => $this->getCard($message, $headerTitle, 'red'),
        ]);
    }

    protected function getCard(string $message, string $headerTitle, string $template): array
    {
        return [
            'config' => [
                'wide_screen_mode' => true,
            ],
            'elements' => [
                [
                    'tag' => 'markdown',
                    'content' => $message,
                ],
            ],
            'header' => [
                'template' => $template,
                'title' => [
                    'content' => $headerTitle,
                    'tag' => 'plain_text',
                ],
            ],
        ];
    }

    #[ArrayShape(['timestamp' => "int", 'sign' => "string"])]
    protected function getSign(): array
    {
        $timestamp = time();
        $key = $timestamp."\n".$this->secret;

        $sign = base64_encode(hash_hmac('sha256', '', $key, true));

        return [
            'timestamp' => $timestamp,
            'sign' => $sign,
        ];
    }
}
