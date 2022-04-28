<?php

namespace Papaedu\Extension\TencentCloud\Vod\Enums;

/**
 * @deprecated
 */
class Media
{
    // 轨道类型
    public const TRACK_TYPE_VIDEO = 'Video';// 视频轨道

    public const TRACK_TYPE_AUDIO = 'Audio';// 音频轨道

    public const TRACK_TYPE_STICKER = 'Sticker';// 贴图轨道

    // 片段类型
    public const TRACK_ITEM_TYPE_VIDEO = 'Video';// 视频片段

    public const TRACK_ITEM_TYPE_AUDIO = 'Audio';// 音频片段

    public const TRACK_ITEM_TYPE_STICKER = 'Sticker';// 贴图片段

    public const TRACK_ITEM_TYPE_TRANSITION = 'Transition';// 转场

    public const TRACK_ITEM_TYPE_EMPTY = 'Empty';// 空白片段

    // 任务流状态变更通知模式
    public const TASK_NOTIFY_MODE_FINISH = 'Finish';

    public const TASK_NOTIFY_MODE_CHANGE = 'Change';

    public const TASK_NOTIFY_MODE_NONE = 'None';
}
