<?php

namespace Papaedu\Extension\UmengPush;

class UmengPush
{
    const SDK_VERSION = 'v1.4';

    /**
     * @var array
     */
    private $config;

    private $ios = null;

    private $android = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return \Papaedu\Extension\UmengPush\IOSPush
     */
    public function ios()
    {
        if (is_null($this->ios)) {
            $this->ios = new IOSPush(
                $this->config['ios']['app_key'],
                $this->config['ios']['app_master_secret'],
                $this->config['production_mode']
            );
        }

        return $this->ios;
    }

    /**
     * @return \Papaedu\Extension\UmengPush\AndroidPush
     */
    public function android()
    {
        if (is_null($this->android)) {
            $this->android = new AndroidPush(
                $this->config['android']['app_key'],
                $this->config['android']['app_master_secret'],
                $this->config['production_mode']
            );
        }

        return $this->android;
    }

    /**
     * @param  string  $alias
     * @param  \Papaedu\Extension\Channels\UmengPush\UmengPushMessage  $message
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function send(string $alias, $message)
    {
        $this->ios()->sendCustomizedcastByAlias(
            $alias,
            'account',
            $message->toPredefinedForIOS(),
            $message->toClientField()
        );
        $this->android()->sendCustomizedcastByAlias(
            $alias,
            'userName',
            $message->toPredefinedForAndroid(),
            $message->toClientField()
        );
    }
}
