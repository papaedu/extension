<?php

namespace Papaedu\Extension\UmengPush\Notifications;

interface UmengNotificationInterface
{
    /**
     * Set key/value for $data array,
     * for the keys which can be set please see $DATA_KEYS,
     * $PAYLOAD_KEYS, $BODY_KEYS, $POLICY_KEYS
     *
     * @param  string  $key
     * @param  string  $value
     */
    public function setPredefinedKeyValue(string $key, string $value);
}
