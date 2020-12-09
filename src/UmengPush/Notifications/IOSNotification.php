<?php

namespace Papaedu\Extension\UmengPush\Notifications;

use Papaedu\Extension\Http\Exceptions\UmengNotificationException;

abstract class IOSNotification extends UmengNotification
{
    /**
     * The array for payload, please see API doc for more information
     *
     * @var array
     */
    protected $iosPayload = [
        'aps' => [
            'alert' => null,
        ],
    ];

    /**
     * Keys can be set in the aps level
     *
     * @var string[]
     */
    protected $apsKeys = ['alert', 'badge', 'sound', 'content-available'];

    public function __construct()
    {
        $this->data['payload'] = $this->iosPayload;
    }

    /**
     * Set key/value for $data array,
     * for the keys which can be set please see $dataKeys,
     * $payloadKeys, $bodyKeys, $policyKeys
     *
     * @param  string  $key
     * @param  string|int|array  $value
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function setPredefinedKeyValue(string $key, $value)
    {
        if (in_array($key, $this->dataKeys)) {
            $this->data[$key] = $value;
        } elseif (in_array($key, $this->apsKeys)) {
            $this->data['payload']['aps'][$key] = $value;
        } elseif (in_array($key, $this->policyKeys)) {
            $this->data['policy'][$key] = $value;
        } elseif (in_array($key, ['payload', 'policy', 'aps'])) {
            throw new UmengNotificationException(
                "You don't need to set value for ${key} , just set values for the sub keys in it."
            );
        } else {
            throw new UmengNotificationException("Unknown key: ${key}");
        }
    }

    /**
     * Set extra key/value for Android notification
     *
     * @param  string  $key
     * @param  string|int|array  $value
     */
    public function setCustomizedField(string $key, $value)
    {
        $this->data['payload'][$key] = $value;
    }
}
