<?php

namespace Papaedu\Extension\UmengPush\Notifications\Traits;

use Illuminate\Support\Facades\Http;
use Papaedu\Extension\Http\Exceptions\UmengNotificationException;

trait FileTrait
{
    /**
     * Upload file with device_tokens or alias to Umeng
     *
     * @param  string  $content
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function uploadContents(string $content)
    {
        if ($this->data['appkey'] == null) {
            throw new UmengNotificationException('appkey should not be NULL!');
        }

        if ($this->data['timestamp'] == null) {
            throw new UmengNotificationException('timestamp should not be NULL!');
        }

        $data = [
            'appkey' => $this->data['appkey'],
            'timestamp' => $this->data['timestamp'],
            'content' => $content,
        ];
        $url = $this->host . $this->uploadPath;
        $sign = $this->generateSign($url, $data);
        $url .= "?sign={$sign}";

        $response = Http::asJson()->post($url, $data);
        $body = $response->body();

        if ('200' != $response->status()) {
            throw new UmengNotificationException("Status code:{$response->status()}, body: {$body}");
        }
        $result = $response->json();
        if ($result['ret'] == 'FAIL') {
            throw new UmengNotificationException("Failed to upload file, body: {$body}");
        } else {
            $this->data['file_id'] = $result['data']['file_id'];
        }
    }

    public function getFileId()
    {
        return $this->data['file_id'] ?? null;
    }
}
