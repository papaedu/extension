<?php

namespace Papaedu\Extension\Enums;

use BenSampo\Enum\Enum;

final class ClassType extends Enum
{


    public static function alias($alias)
    {
        if (!$alias) {
            return 0;
        }

        return [
                'user_share' => self::USER_SHARE,
                'ad_q' => self::AD_Q,
                'keyword_reply' => self::KEYWORD_REPLY,
                'ieltsassistant' => self::IELTS_ASSISTANT,
            ][$alias] ?? 0;
    }
}
