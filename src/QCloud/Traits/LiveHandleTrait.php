<?php

namespace Extension\QCloud\Traits;

use BiuBiuJun\QCloud\Exceptions\BadRequestException;
use BiuBiuJun\QCloud\Exceptions\QCloudException;
use Extension\QCloud\Tim\TimClient;
use Extension\QCloud\Tiw\TiwRecord;
use Illuminate\Database\Eloquent\Model;
use Modules\CoursePlan\Enums\CoursePlanTaskStatus;
use Modules\Live\Jobs\TrtcDismissRoom;

/**
 * @property \Papaedu\Extension\Support\Logger $logger
 * @property \Papaedu\Extension\Support\Response $response
 */
trait LiveHandleTrait
{
    use LiveRedisTrait;

    /**
     * @var \Extension\QCloud\Tim\TimClient
     */
    protected $timClient;

    /**
     * @var \Extension\QCloud\Tiw\TiwRecord
     */
    protected $tiwRecord;

    /**
     * @return \Extension\QCloud\Tim\TimClient
     */
    protected function getTimClient()
    {
        if (!$this->timClient instanceof TimClient) {
            $this->timClient = new TimClient();
        }

        return $this->timClient;
    }

    /**
     * Get Tiw record object.
     *
     * @return \Extension\QCloud\Tiw\TiwRecord
     */
    protected function getTiwRecord()
    {
        if (!$this->tiwRecord instanceof TiwRecord) {
            $this->tiwRecord = new TiwRecord();
        }

        return $this->tiwRecord;
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $uuid
     * @param  string  $liveRoomId
     */
    public function handleLiveRecordDetail(Model &$model, string $uuid, string $liveRoomId)
    {
        try {
            $privateMapKey = $this->getTimClient()->getPrivateMapKey($uuid, $liveRoomId, 21600);
            $model->setAttribute('private_map_key', $privateMapKey);

            $sideUser = "desktop_sharing_{$liveRoomId}";
            $model->setAttribute('side_user', [
                'identifier' => $sideUser,
                'sign' => $this->getTimClient()->getUserSign($sideUser),
            ]);

            $this->logger->info('handleLiveRecordDetail', [
                'id' => $model->id,
            ]);
        } catch (QCloudException $e) {
            $this->logger->error('handleLiveRecordDetail', $e, [
                'model' => $model,
            ]);

            $this->response->errorInternalServerError();
        }
    }

    /**
     * @param  int  $liveRoomId
     * @param  string  $uuid
     * @param  bool  $isVideoCall
     */
    public function handleStartRecord(int $liveRoomId, string $uuid, bool $isVideoCall = false)
    {
        try {
            $taskId = $this->getTiwRecord()->startOnlineRecord($liveRoomId, $uuid, $isVideoCall);
            $this->setOnlineRecordRoomTaskId($liveRoomId, $taskId);
            $this->setOnlineRecordRoomStartedAtList($liveRoomId, date('Y-m-d H:i:s'));

            $this->logger->info('handleStartRecord', [
                'live_room_id' => $liveRoomId,
                'task_id' => $taskId,
            ]);
        } catch (BadRequestException $e) {
            $message = json_decode($e->getMessage(), true);
            switch ($message['Error']['Code']) {
                case 'ResourceInUse.RecordUserId':// 用户重复录制
                    $this->logger->error('handleStartRecord recordUserIdRepetitive', null, [
                        'live_room_id' => $liveRoomId,
                        'message' => $message,
                    ]);
                    break;
                case 'LimitExceeded.TaskConcurrency':// 已有录制任务
                    $this->logger->error('handleStartRecord repetitiveOperation', null, [
                        'live_room_id' => $liveRoomId,
                        'message' => $message,
                    ]);
                    break;
                default:
                    $this->logger->error('handleStartRecord undefinedBadRequest', $e, [
                        'live_room_id' => $liveRoomId,
                        'message' => $message,
                    ]);

                    $this->response->errorInternalServerError();
            }
        } catch (QCloudException $e) {
            $this->logger->error('handleStartRecord', $e, [
                'live_room_id' => $liveRoomId,
                'message' => $e->getMessage(),
            ]);

            $this->response->errorInternalServerError();
        }
    }

    /**
     * @param  string  $liveRoomId
     */
    public function handleStopRecord(string $liveRoomId)
    {
        $taskId = $this->getLastRecordTaskId($liveRoomId);
        try {
            $this->getTiwRecord()->stopOnlineRecord($taskId);

            $this->logger->info('handleStopRecord', [
                'live_room_id' => $liveRoomId,
                'task_id' => $taskId,
            ]);
        } catch (BadRequestException $e) {
            $message = json_decode($e->getMessage(), true);
            switch ($message['Error']['Code']) {
                case 'UnsupportedOperation.TaskHasAlreadyStopped':// 录制任务已停止
                    $this->logger->info('handleStopRecord *repetitive operation*', [
                        'live_room_id' => $liveRoomId,
                        'task_id' => $taskId,
                        'message' => $message,
                    ]);
                    break;
                default:
                    $this->logger->error('handleStopRecord', $e, [
                        'live_room_id' => $liveRoomId,
                        'task_id' => $taskId,
                        'message' => $message,
                    ]);
                    $this->response->errorInternalServerError();
            }
        } catch (QCloudException $e) {
            $this->logger->error('handleStopRecord', $e, [
                'live_room_id' => $liveRoomId,
                'task_id' => $taskId,
                'message' => $e->getMessage(),
            ]);

            $this->response->errorInternalServerError();
        }
    }

    /**
     * @param $model
     */
    public function handleDismissRoom($model)
    {
        $this->logger->info('dismissRoom', [
            'id' => $model->id,
        ]);

        TrtcDismissRoom::dispatch($model, false);
    }

    /**
     * @param  string  $liveRoomId
     */
    public function handleImPermission(string $liveRoomId)
    {
        try {
            $this->getTimClient()->setPermission($liveRoomId, $this->authUser->uuid);

            $this->logger->info('setImPermission', [
                'live_room_id' => $liveRoomId,
            ]);
        } catch (QCloudException $e) {
            $this->logger->error('setImPermission', $e, [
                'live_room_id' => $liveRoomId,
                'uuid' => $this->authUser->uuid,
                'message' => $e->getMessage(),
            ]);

            $this->response->errorInternalServerError();
        }
    }

    /**
     * @param  \Modules\CoursePlan\Entities\CoursePlanTask|\Modules\Course\Entities\CourseSchedule  $model
     * @param  bool  $isFinished
     */
    protected function liveValidate($model, bool $isFinished = false)
    {
        $status = CoursePlanTaskStatus::getConversion($model->status);

        if (CoursePlanTaskStatus::Booked == $status && !$model->live_room_id) {
            $this->response->errorBadRequest('该课程不在本平台授课，请联系小总管');
        }

        if (CoursePlanTaskStatus::Finished == $status) {
            $this->response->errorBadRequest('该课程已完成，无法继续上课');
        }

        if (CoursePlanTaskStatus::Canceled == $status && !$model->is_recorded) {
            $this->response->errorBadRequest('该课程已取消，无法继续上课');
        }

        if ($isFinished && $model->taught_finish_at->lt(now()->subHour())) {
            $this->response->errorBadRequest('下课1小时后无法进入教室');
        }

        if ($model->taught_at->gt(now()->addHour())) {
            $this->response->errorBadRequest('开课前1小时才可进入教室');
        }
    }
}
