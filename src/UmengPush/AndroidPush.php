<?php

namespace Papaedu\Extension\UmengPush;

use Papaedu\Extension\UmengPush\Notifications\Android\AndroidBroadcast;
use Papaedu\Extension\UmengPush\Notifications\Android\AndroidCustomizedcast;
use Papaedu\Extension\UmengPush\Notifications\Android\AndroidFilecast;
use Papaedu\Extension\UmengPush\Notifications\Android\AndroidGroupcast;
use Papaedu\Extension\UmengPush\Notifications\Android\AndroidListcast;
use Papaedu\Extension\UmengPush\Notifications\Android\AndroidUnicast;

class AndroidPush extends PushAbstract
{
    /**
     * 发送广播
     *
     * @param  array  $predefined
     * @param  array  $extraField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendBroadcast(array $predefined = [], array $extraField = []): string
    {
        $broadcast = new AndroidBroadcast();
        $this->initCast($broadcast, $predefined, $extraField);

        return $broadcast->send();
    }

    /**
     * 发送单播
     *
     * @param  string  $deviceTokens
     * @param  array  $predefined
     * @param  array  $extraField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendUnicast(string $deviceTokens = '', array $predefined = [], array $extraField = []): string
    {
        $unicast = new AndroidUnicast();
        $this->initCast($unicast, $predefined, $extraField);
        $unicast->setPredefinedKeyValue('device_tokens', $deviceTokens);

        return $unicast->send();
    }

    /**
     * 发送列播
     *
     * @param  string  $deviceTokens
     * @param  array  $predefined
     * @param  array  $extraField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendListcast(string $deviceTokens = '', array $predefined = [], array $extraField = []): string
    {
        $listcast = new AndroidListcast();
        $this->initCast($listcast, $predefined, $extraField);
        $listcast->setPredefinedKeyValue('device_tokens', $deviceTokens);

        return $listcast->send();
    }

    /**
     * 发送文件播
     *
     * @param  string  $fileContents
     * @param  array  $predefined
     * @param  array  $extraField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendFilecast(string $fileContents = '', array $predefined = [], array $extraField = []): string
    {
        $filecast = new AndroidFilecast();
        $this->initCast($filecast, $predefined, $extraField);
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
        $groupcast = new AndroidGroupcast();
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
     * @param  array  $extraField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendCustomizedcastByAlias(
        string $alias = '',
        $aliasType = '',
        array $predefined = [],
        array $extraField = []
    ): string {
        $customizedcast = new AndroidCustomizedcast();
        $this->initCast($customizedcast, $predefined, $extraField);
        $customizedcast->setPredefinedKeyValue('alias', $alias);
        $customizedcast->setPredefinedKeyValue('alias_type', $aliasType);

        return $customizedcast->send();
    }

    /**
     * 通过file_id发送自定义播
     *
     * @param  string  $fileContents
     * @param  array  $predefined
     * @param  array  $extraField
     * @return string
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function sendCustomizedcastByFileId(
        string $fileContents = '',
        array $predefined = [],
        array $extraField = []
    ): string {
        $customizedcast = new AndroidCustomizedcast();
        $this->initCast($customizedcast, $predefined, $extraField);
        $customizedcast->uploadContents($fileContents);

        return $customizedcast->send();
    }
}
