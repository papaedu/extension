<?php

namespace Papaedu\Extension\UmengPush;

use Papaedu\Extension\UmengPush\Notifications\IOS\IOSBroadcast;
use Papaedu\Extension\UmengPush\Notifications\IOS\IOSCustomizedcast;
use Papaedu\Extension\UmengPush\Notifications\IOS\IOSFilecast;
use Papaedu\Extension\UmengPush\Notifications\IOS\IOSGroupcast;
use Papaedu\Extension\UmengPush\Notifications\IOS\IOSListcast;
use Papaedu\Extension\UmengPush\Notifications\IOS\IOSUnicast;

class IOSPush extends PushAbstract
{
    /**
     * 发送广播
     *
     * @param  array  $predefined
     * @param  array  $customField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendBroadcast(array $predefined = [], array $customField = []): string
    {
        $broadcast = new IOSBroadcast();
        $this->initCast($broadcast, $predefined, $customField);

        return $broadcast->send();
    }

    /**
     * 发送单播
     *
     * @param  string  $deviceTokens
     * @param  array  $predefined
     * @param  array  $customField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendUnicast(string $deviceTokens = '', array $predefined = [], array $customField = []): string
    {
        $unicast = new IOSUnicast();
        $this->initCast($unicast, $predefined, $customField);
        $unicast->setPredefinedKeyValue('device_tokens', $deviceTokens);

        return $unicast->send();
    }

    /**
     * 发送列播
     *
     * @param  string  $deviceTokens
     * @param  array  $predefined
     * @param  array  $customField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendListcast(string $deviceTokens = '', array $predefined = [], array $customField = []): string
    {
        $listcast = new IOSListcast();
        $this->initCast($listcast, $predefined, $customField);
        $listcast->setPredefinedKeyValue('device_tokens', $deviceTokens);

        return $listcast->send();
    }

    /**
     * 发送文件播
     *
     * @param  string  $fileContents
     * @param  array  $predefined
     * @param  array  $customField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendFilecast(string $fileContents = '', array $predefined = [], array $customField = []): string
    {
        $filecast = new IOSFilecast();
        $this->initCast($filecast, $predefined, $customField);
        $filecast->uploadContents($fileContents);

        return $filecast->send();
    }

    /**
     * 发送组播
     *
     * @param  array  $filter
     * @param  array  $predefined
     * @param  array  $customFiled
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendGroupcast(array $filter = [], array $predefined = [], array $customFiled = []): string
    {
        $groupcast = new IOSGroupcast();
        $this->initCast($groupcast, $predefined, $customFiled);
        $groupcast->setPredefinedKeyValue('filter', $filter);

        return $groupcast->send();
    }

    /**
     * 通过alias发送自定义播
     *
     * @param  string  $alias
     * @param  string  $aliasType
     * @param  array  $predefined
     * @param  array  $customField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendCustomizedcastByAlias(
        string $alias = '',
        $aliasType = '',
        array $predefined = [],
        array $customField = []
    ): string {
        $customizedcast = new IOSCustomizedcast();
        $this->initCast($customizedcast, $predefined, $customField);
        $customizedcast->setPredefinedKeyValue('alias', $alias);
        $customizedcast->setPredefinedKeyValue('alias_type', $aliasType);

        return $customizedcast->send();
    }

    /**
     * 通过file_id发送自定义播
     *
     * @param  string  $fileContents
     * @param  array  $predefined
     * @param  array  $customField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendCustomizedcastByFileId(
        string $fileContents = '',
        array $predefined = [],
        array $customField = []
    ): string {
        $customizedcast = new IOSCustomizedcast();
        $this->initCast($customizedcast, $predefined, $customField);
        $customizedcast->uploadContents($fileContents);

        return $customizedcast->send();
    }
}
