<?php

namespace Papaedu\Extension\TencentCloud\Tim\Requests\GroupOpenHttpSvc\Enums;

enum GroupType: string
{
    case PUBLIC = 'Public';// 公开群

    case PRIVATE = 'Private';// 私密群

    case CHATROOM = 'ChatRoom';// 聊天室

    case AV_CHATROOM = 'AVChatRoom';// 音视频聊天室

    case B_CHATROOM = 'BChatRoom';// 在线成员广播大群
}
