<?php

namespace Papaedu\Extension\TencentCloud\Vod\Enums;

enum VodTrackType: string
{
    case VIDEO = 'Video';// 视频轨道

    case AUDIO = 'Audio';// 音频轨道

    case STICKER = 'Sticker';// 贴图轨道
}
