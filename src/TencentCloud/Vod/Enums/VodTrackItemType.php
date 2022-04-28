<?php

namespace Papaedu\Extension\TencentCloud\Vod\Enums;

enum VodTrackItemType: string
{
    case VIDEO = 'Video';// 视频片段

    case AUDIO = 'Audio';// 音频片段

    case STICKER = 'Sticker';// 贴图片段

    case TRANSITION = 'Transition';// 转场

    case EMPTY = 'Empty';// 空白片段
}
