<?php

namespace Papaedu\Extension\UmengPush;

use Papaedu\Extension\Http\Exceptions\UmengNotificationException;
use Papaedu\Extension\UmengPush\Notifications\AndroidNotification;
use Papaedu\Extension\UmengPush\Notifications\IOSNotification;
use Papaedu\Extension\UmengPush\Notifications\UmengNotificationInterface;

abstract class PushAbstract
{
    /**
     * @var string
     */
    protected string $appKey;

    /**
     * @var string
     */
    protected string $appMaterSecret;

    /**
     * @var bool
     */
    protected bool $productionMode;

    public function __construct(string $appKey, string $appMaterSecret, bool $productionMode)
    {
        $this->appKey = $appKey;
        $this->appMaterSecret = $appMaterSecret;
        $this->productionMode = $productionMode;
    }

    /**
     * @param  \Papaedu\Extension\UmengPush\Notifications\UmengNotificationInterface  $cast
     * @param  array  $predefined
     * @param  array  $clientField
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    protected function initCast(UmengNotificationInterface &$cast, array $predefined = [], array $clientField = [])
    {
        $cast->setAppMasterSecret($this->appMaterSecret);
        $cast->setPredefinedKeyValue('appkey', $this->appKey);
        $cast->setPredefinedKeyValue('timestamp', strval(time()));
        $cast->setPredefinedKeyValue('production_mode', $this->productionMode);

        foreach ($predefined as $key => $value) {
            $cast->setPredefinedKeyValue($key, $value);
        }

        if ($cast instanceof IOSNotification) {
            foreach ($clientField as $key => $value) {
                $cast->setCustomizedField($key, $value);
            }
        } elseif ($cast instanceof AndroidNotification) {
            foreach ($clientField as $key => $value) {
                $cast->setExtraField($key, $value);
            }
        } else {
            throw new UmengNotificationException('Init cast\'s abstract class undefined.');
        }
    }
}
