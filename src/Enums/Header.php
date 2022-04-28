<?php

namespace Papaedu\Extension\Enums;

enum Header: string
{
    case APP_NAME = 'app-name';

    case DEVICE_ID = 'device-id';

    case DEVICE_NAME = 'device-name';

    case PLATFORM = 'platform';

    case CHANNEL = 'channel';

    case VERSION = 'version';

    case SIGN = 'sign';

    case TIMESTAMP = 'timestamp';

    case LANG = 'lang';

    case USER_AGENT = 'user-agent';
}
