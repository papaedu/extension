<?php

namespace Papaedu\Extension\UmengPush\Notifications;

use Illuminate\Support\Facades\Http;
use Papaedu\Extension\Http\Exceptions\UmengNotificationException;

abstract class UmengNotification implements UmengNotificationInterface
{
    /**
     * @var string
     */
    protected $host = 'http://msg.umeng.com';

    /**
     * @var string
     */
    protected $uploadPath = '/upload';

    /**
     * @var string
     */
    protected $postPath = '/api/send';

    /**
     * @var null
     */
    protected $appMasterSecret = null;

    /**
     * $data is designed to construct the json string for POST request. Note:
     * 1)The key/value pairs in comments are optional.
     * 2)The value for key 'payload' is set in the subclass(AndroidNotification or IOSNotification),
     * as their payload structures are different.
     *
     * @var array
     */
    protected $data = [
        'appkey' => null,
        'timestamp' => null,
        'type' => null,
        'production_mode' => 'true',
    ];

    protected $dataKeys = [
        'appkey',
        'timestamp',
        'type',
        'device_tokens',
        'alias',
        'alias_type',
        'file_id',
        'filter',
        'production_mode',
        'feedback',
        'description',
        'thirdparty_id',
    ];

    protected $policyKeys = [
        'start_time',
        'expire_time',
        'max_send_num',
    ];

    public function setAppMasterSecret($secret)
    {
        $this->appMasterSecret = $secret;
    }

    /**
     * return TRUE if it's complete, otherwise throw exception with details
     *
     * @return bool
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function isComplete()
    {
        if (is_null($this->appMasterSecret)) {
            throw new UmengNotificationException('Please set your app master secret for generating the signature!');
        }

        $this->checkArrayValues($this->data);

        return true;
    }

    /**
     * @param  array  $array
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    private function checkArrayValues(array $array)
    {
        foreach ($array as $key => $value) {
            if (is_null($value)) {
                throw new UmengNotificationException($key.' is NULL!');
            } elseif (is_array($value)) {
                $this->checkArrayValues($value);
            }
        }
    }

    /**
     * send the notification to umeng, return response data if SUCCESS , otherwise throw Exception with details.
     *
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function send()
    {
        // check the fields to make sure that they are not NULL
        $this->isComplete();

        $url = $this->host.$this->postPath;
        $sign = $this->generateSign($url, $this->data);
        $url .= "?sign={$sign}";

        $response = Http::asJson()->post($url, $this->data);
        $body = $response->body();
        if ('200' != $response->status()) {
            throw new UmengNotificationException("Status code:{$response->status()}, body: {$body}");
        }

        return $body;
    }

    /**
     * @param  string  $url
     * @param  array  $data
     * @return string
     */
    protected function generateSign(string $url, array $data)
    {
        $json = json_encode($data);

        return md5("POST{$url}{$json}{$this->appMasterSecret}");
    }
}
