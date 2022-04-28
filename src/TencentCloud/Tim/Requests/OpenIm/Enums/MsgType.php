<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\OpenIm\Enums;

enum MsgType: string
{
    case TEXT = 'TIMTextElem';

    case LOCATION = 'TIMLocationElem';

    case FACE = 'TIMFaceElem';

    case CUSTOM = 'TIMCustomElem';

    case SOUND = 'TIMSoundElem';

    case IMAGE = 'TIMImageElem';

    case FILE = 'TIMFileElem';

    case VIDEO_FILE = 'TIMVideoFileElem';
}
