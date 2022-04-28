<?php

namespace Papaedu\Extension\Models\Methods;

use Illuminate\Support\Facades\Redis;

trait MediaLibraryMethod
{
    public static function setScanTaskId(string $taskId, int $id)
    {
        Redis::hset(self::SCAN_TASK_IDS_KEY, $taskId, $id);
    }

    public static function getScanTaskIdInfo(string $taskId)
    {
        $id = Redis::hget(self::SCAN_TASK_IDS_KEY, $taskId);
        if (empty($id)) {
            return null;
        }

        return self::query()->find($id);
    }

    public static function deleteScanTaskId(string $taskId)
    {
        Redis::hdel(self::SCAN_TASK_IDS_KEY, $taskId);
    }
}
