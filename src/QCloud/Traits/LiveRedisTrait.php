<?php

namespace Extension\QCloud\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use Modules\Course\Enums\CourseMode;

trait LiveRedisTrait
{
    /**
     * 音视频实时录制房间的信息.
     *
     * @var string
     */
    private $trtcOnlineRecordRoomInfoKey = 'trtc:online_record:room_id:%s:info';

    /**
     * 音视频实时录制房间的所有任务ID(倒序).
     *
     * @var string
     */
    private $trtcOnlineRecordRoomTaskIdsKey = 'trtc:online_record:room_id:%s:task_ids';

    /**
     * 音视频实时录制房间的每个截点开始时间(点击开始且真实分段的时间为开始时间).
     *
     * @var string
     */
    private $trtcOnlineRecordRoomStartedAtListKey = 'trtc:online_record:room_id:%s:started_at_list';

    /**
     * 音视频实时录制房间的每个截点结束时间(收到视频推送的时间为结束时间).
     *
     * @var string
     */
    private $trtcOnlineRecordRoomEndedAtListKey = 'trtc:online_record:room_id:%s:ended_at_list';

    /**
     * 音视频实时录制房间中所有上传云点播的任务ID.
     *
     * @var string
     */
    private $trtcOnlineRecordVodTaskIdsKey = 'trtc:online_record:room_id:%s:vod:task_ids';

    /**
     * 云点播任务的视频信息.
     *
     * @var string
     */
    private $vodTaskVideoInfoKey = 'vod:task_id:%s:video_info';

    /**
     * 云点播合成视频任务的音视频实时录制房间号.
     *
     * @var string
     */
    private $vodComposeTaskOnlineRecordRoomKey = 'vod:compose:task_id:%s:room_id';

    /**
     * 云点播转码视频任务的音视频实时录制房间号.
     *
     * @var string
     */
    private $vodTranscodeTaskOnlineRecordRoomKey = 'vod:transcode:task_id:%s:room_id';

    /**
     * 教师文档转码任务ID.
     *
     * @var string
     */
    private $documentTaskIdKey = 'teacher_document:task_id:%s:primary_id';

    /*
     * 音视频
     */

    /**
     * 设置音视频实时录制房间信息.
     *
     * @param  string  $roomId
     * @param  int  $primaryId
     * @param  int  $classType
     */
    public function setOnlineRecordRoomInfo(string $roomId, int $primaryId, int $classType)
    {
        Redis::hmset(sprintf($this->trtcOnlineRecordRoomInfoKey, $roomId), [
            'primary_id' => $primaryId,
            'class_type' => $classType,
        ]);
    }

    /**
     * 获取音视频实时录制房间信息.
     *
     * @param  string  $roomId
     * @return array
     */
    public function getOnlineRecordRoomInfo(string $roomId)
    {
        return Redis::hgetall(sprintf($this->trtcOnlineRecordRoomInfoKey, $roomId));
    }

    /**
     * 获取音视频实时录制房间信息中的具体参数.
     *
     * @param  string  $roomId
     * @param  string  $field
     * @return string
     */
    public function getOnlineRecordRoomInfoField(string $roomId, string $field)
    {
        return Redis::hget(sprintf($this->trtcOnlineRecordRoomInfoKey, $roomId), $field);
    }

    /**
     * 设置音视频实时录制的每个任务ID(倒序).
     *
     * @param  string  $roomId
     * @param  string  $taskId
     */
    public function setOnlineRecordRoomTaskId(string $roomId, string $taskId)
    {
        Redis::lpush(sprintf($this->trtcOnlineRecordRoomTaskIdsKey, $roomId), $taskId);
    }

    /**
     * 获取音视频实时录制的最后一个任务ID.
     *
     * @param  string  $roomId
     * @return string
     */
    public function getLastRecordTaskId(string $roomId)
    {
        return Redis::lindex(sprintf($this->trtcOnlineRecordRoomTaskIdsKey, $roomId), 0);
    }

    /**
     * 获取音视频实时录制的任务个数.
     *
     * @param  string  $roomId
     * @return int
     */
    public function getOnlineRecordTaskCount(string $roomId)
    {
        return Redis::llen(sprintf($this->trtcOnlineRecordRoomTaskIdsKey, $roomId));
    }

    /**
     * 设置音视频实时录制房间中每个上传云点播的任务ID(无序).
     *
     * @param  string  $roomId
     * @param  string  $taskId
     */
    public function setOnlineRecordVodTaskId(string $roomId, string $taskId)
    {
        Redis::sadd(sprintf($this->trtcOnlineRecordVodTaskIdsKey, $roomId), $taskId);
    }

    /**
     * 获取音视频实时录制房间中上传云点播的任务个数.
     *
     * @param  string  $roomId
     * @return int
     */
    public function getOnlineRecordVodTaskCount(string $roomId)
    {
        return Redis::scard(sprintf($this->trtcOnlineRecordVodTaskIdsKey, $roomId));
    }

    /**
     * 获取音视频实时录制房间中所有上传云点播的任务视频信息(正序).
     *
     * @param  string  $roomId
     * @return array
     */
    public function getOnlineRecordVodTaskInfos(string $roomId)
    {
        $vodTaskIds = Redis::smembers(sprintf($this->trtcOnlineRecordVodTaskIdsKey, $roomId));

        $vodTaskInfos = [];
        foreach ($vodTaskIds as $vodTaskId) {
            $vodTaskInfos[] = $this->getVodTaskVideoInfo($vodTaskId);
        }

        return Arr::sort($vodTaskInfos, function ($value) {
            return $value['video_started_at'];
        });
    }

    /**
     * 设置音视频实时录制房间每次的开始时间.
     *
     * @param  string  $roomId
     * @param  string  $startedAt
     */
    public function setOnlineRecordRoomStartedAtList(string $roomId, string $startedAt)
    {
        Redis::rpush(sprintf($this->trtcOnlineRecordRoomStartedAtListKey, $roomId), $startedAt);
    }

    /**
     * 获取音视频实时录制房间开始时间总数.
     *
     * @param  string  $roomId
     * @return int
     */
    public function getOnlineRecordRoomStartedAtCount(string $roomId)
    {
        return Redis::llen(sprintf($this->trtcOnlineRecordRoomStartedAtListKey, $roomId));
    }

    /**
     * 设置音视频实时录制房间每次的结束时间.
     *
     * @param  string  $roomId
     * @param  string  $endedAt
     */
    public function setOnlineRecordRoomEndedAtList(string $roomId, string $endedAt)
    {
        Redis::rpush(sprintf($this->trtcOnlineRecordRoomEndedAtListKey, $roomId), $endedAt);
    }

    /**
     * 获取音视频实时录制房间结束时间总数.
     *
     * @param  string  $roomId
     * @return int
     */
    public function getOnlineRecordRoomEndedAtCount(string $roomId)
    {
        return Redis::llen(sprintf($this->trtcOnlineRecordRoomEndedAtListKey, $roomId));
    }

    /**
     * 判断音视频实时录制房间是否已经结束.
     *
     * @param  string  $roomId
     * @return bool
     */
    public function getOnlineRecordRoomIsEnd(string $roomId)
    {
        return $this->getOnlineRecordRoomStartedAtCount($roomId) == $this->getOnlineRecordRoomEndedAtCount($roomId);
    }

    /**
     * 清理Trtc.
     *
     * @param  string  $roomId
     */
    public function clearTrtc(string $roomId)
    {
        $keys = [
            sprintf($this->trtcOnlineRecordRoomInfoKey, $roomId),
            sprintf($this->trtcOnlineRecordRoomTaskIdsKey, $roomId),
            sprintf($this->trtcOnlineRecordVodTaskIdsKey, $roomId),
            sprintf($this->trtcOnlineRecordRoomStartedAtListKey, $roomId),
            sprintf($this->trtcOnlineRecordRoomEndedAtListKey, $roomId),
        ];
        $vodTaskIds = Redis::smembers(sprintf($this->trtcOnlineRecordVodTaskIdsKey, $roomId));
        foreach ($vodTaskIds as $vodTaskId) {
            $keys[] = sprintf($this->vodTaskVideoInfoKey, $vodTaskId);
        }

        Redis::del($keys);
    }

    /**
     * 设置云点播任务的视频信息 - 直播.
     *
     * @param  string  $taskId
     * @param  string  $roomId
     * @param  int  $videoStartedAt
     * @param  int  $videoDuration
     * @param  int  $videoSize
     */
    public function setVodTaskVideoInfoByLive(
        string $taskId,
        string $roomId,
        int $videoStartedAt,
        int $videoDuration,
        int $videoSize
    ) {
        Redis::hmset(sprintf($this->vodTaskVideoInfoKey, $taskId), [
            'course_mode' => CourseMode::Live,
            'room_id' => $roomId,
            'video_started_at' => $videoStartedAt,
            'video_duration' => $videoDuration,
            'video_size' => $videoSize,
        ]);
    }

    /**
     * 设置云点播任务的视频信息 - 视频.
     *
     * @param  string  $taskId
     * @param  int  $primaryId
     * @param  int  $classType
     */
    public function setVodTaskVideoInfoByVideo(string $taskId, int $primaryId, int $classType)
    {
        Redis::hmset(sprintf($this->vodTaskVideoInfoKey, $taskId), [
            'course_mode' => CourseMode::Video,
            'primary_id' => $primaryId,
            'class_type' => $classType,
        ]);
    }

    /**
     * 设置云点播任务的视频主要信息.
     *
     * @param  string  $taskId
     * @param  string  $videoId
     * @param  string  $videoUrl
     */
    public function setVodTaskMainVideoInfo(string $taskId, string $videoId, string $videoUrl)
    {
        Redis::hmset(sprintf($this->vodTaskVideoInfoKey, $taskId), [
            'video_id' => $videoId,
            'video_url' => $videoUrl,
        ]);
    }

    /**
     * 获取云点播任务的视频信息.
     *
     * @param  string  $taskId
     * @return array
     */
    public function getVodTaskVideoInfo(string $taskId)
    {
        return Redis::hgetall(sprintf($this->vodTaskVideoInfoKey, $taskId));
    }

    /**
     * 清理云点播拉流任务
     *
     * @param  string  $taskId
     * @return int
     */
    public function clearVodTaskVideoInfo(string $taskId)
    {
        return Redis::del(sprintf($this->vodTaskVideoInfoKey, $taskId));
    }

    /**
     * 设置云点播合成视频任务的音视频实时录制房间号.
     *
     * @param  string  $taskId
     * @param  string  $roomId
     */
    public function setComposeTaskOnlineRecordRoom(string $taskId, string $roomId)
    {
        Redis::set(sprintf($this->vodComposeTaskOnlineRecordRoomKey, $taskId), $roomId);
    }

    /**
     * 获取云点播合成视频任务的音视频实时录制房间号.
     *
     * @param  string  $taskId
     * @return string
     */
    public function getComposeTaskOnlineRecordRoom(string $taskId)
    {
        return Redis::get(sprintf($this->vodComposeTaskOnlineRecordRoomKey, $taskId));
    }

    /**
     * 清理云点播合成视频任务的音视频实时录制房间号.
     *
     * @param  string  $taskId
     * @return int
     */
    public function clearComposeTaskOnlineRecordRoom(string $taskId)
    {
        return Redis::del(sprintf($this->vodComposeTaskOnlineRecordRoomKey, $taskId));
    }

    /**
     * 设置云点播转码视频任务的音视频实时录制房间号.
     *
     * @param  string  $taskId
     * @param  string  $roomId
     */
    public function setTranscodeTaskOnlineRecordRoom(string $taskId, string $roomId)
    {
        Redis::set(sprintf($this->vodTranscodeTaskOnlineRecordRoomKey, $taskId), $roomId);
    }

    /**
     * 获取云点播转码视频任务的音视频实时录制房间号.
     *
     * @param  string  $taskId
     * @return string
     */
    public function getTranscodeTaskOnlineRecordRoom(string $taskId)
    {
        return Redis::get(sprintf($this->vodTranscodeTaskOnlineRecordRoomKey, $taskId));
    }

    /**
     * 清理云点播转码视频任务的音视频实时录制房间号.
     *
     * @param  string  $taskId
     * @return int
     */
    public function clearTranscodeTaskOnlineRecordRoom(string $taskId)
    {
        return Redis::del(sprintf($this->vodTranscodeTaskOnlineRecordRoomKey, $taskId));
    }

    /*
     * 文档转码
     */

    /**
     * @param  string  $taskId
     * @param  int  $teacherDocumentId
     */
    public function setDocumentPrimaryId(string $taskId, int $teacherDocumentId)
    {
        Redis::set(sprintf($this->documentTaskIdKey, $taskId), $teacherDocumentId);
    }

    /**
     * @param  string  $taskId
     * @return string
     */
    public function getDocumentPrimaryId(string $taskId)
    {
        return Redis::get(sprintf($this->documentTaskIdKey, $taskId));
    }

    /**
     * @param  string  $taskId
     */
    public function clearDocument(string $taskId)
    {
        Redis::del(sprintf($this->documentTaskIdKey, $taskId));
    }
}
