<?php

namespace Papaedu\Extension\UmengPush\Notifications;

use Papaedu\Extension\Http\Exceptions\UmengNotificationException;

abstract class AndroidNotification extends UmengNotification
{
    /**
     * The array for payload, please see API doc for more information
     *
     * @var array
     */
    protected $androidPayload = [
        'display_type' => 'notification',
        'body' => [
            'ticker' => null,
            'title' => null,
            'text' => null,
            'play_vibrate' => 'true',
            'play_lights' => 'true',
            'play_sound' => 'true',
            'after_open' => null,
        ],
    ];

    /**
     * Keys can be set in the payload level
     *
     * @var string[]
     */
    protected $payloadKeys = ['display_type'];

    /**
     * Keys can be set in the body level
     *
     * @var string[]
     */
    protected $bodyKeys = [
        'ticker',
        'title',
        'text',
        'builder_id',
        'icon',
        'largeIcon',
        'img',
        'play_vibrate',
        'play_lights',
        'play_sound',
        'after_open',
        'url',
        'activity',
        'custom',
    ];

    public function __construct()
    {
        $this->data['payload'] = $this->androidPayload;
    }

    /**
     * Set key/value for $data array,
     * for the keys which can be set please see $DATA_KEYS,
     * $PAYLOAD_KEYS, $BODY_KEYS, $POLICY_KEYS
     *
     * @param  string  $key
     * @param  string  $value
     * @throws \Papaedu\Extension\Http\Exceptions\UmengNotificationException
     */
    public function setPredefinedKeyValue(string $key, $value)
    {
        if (in_array($key, $this->dataKeys)) {
            $this->data[$key] = $value;
        } elseif (in_array($key, $this->payloadKeys)) {
            $this->data['payload'][$key] = $value;
            if ($key == 'display_type' && $value == 'message') {
                $this->data['payload']['body']['ticker'] = '';
                $this->data['payload']['body']['title'] = '';
                $this->data['payload']['body']['text'] = '';
                $this->data['payload']['body']['after_open'] = '';
                if (!isset($this->data['payload']['body']['custom'])) {
                    $this->data['payload']['body']['custom'] = null;
                }
            }
        } elseif (in_array($key, $this->bodyKeys)) {
            $this->data['payload']['body'][$key] = $value;
            if ($key == 'after_open' && $value == 'go_custom' && !isset($this->data['payload']['body']['custom'])) {
                $this->data['payload']['body']['custom'] = null;
            }
        } elseif (in_array($key, $this->policyKeys)) {
            $this->data['policy'][$key] = $value;
        } elseif (in_array($key, ['payload', 'body', 'policy', 'extra'])) {
            throw new UmengNotificationException(
                "You don't need to set value for ${key}, just set values for the sub keys in it."
            );
        } else {
            throw new UmengNotificationException("Unknown key: ${key}");
        }
    }

    /**
     * Set extra key/value for Android notification
     *
     * @param  string  $key
     * @param  string|int  $value
     */
    public function setExtraField(string $key, $value)
    {
        $this->data['payload']['extra'][$key] = $value;
    }
}
