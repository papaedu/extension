<?php

namespace Extension\QCloud\Tiw;

use BiuBiuJun\QCloud\Tiw\Notifies\OnlineRecordCallbackNotify;
use BiuBiuJun\QCloud\Tiw\Requests\Parameters\Canvas;
use BiuBiuJun\QCloud\Tiw\Requests\Parameters\Concat;
use BiuBiuJun\QCloud\Tiw\Requests\Parameters\CustomLayout;
use BiuBiuJun\QCloud\Tiw\Requests\Parameters\LayoutParams;
use BiuBiuJun\QCloud\Tiw\Requests\Parameters\MixStream;
use BiuBiuJun\QCloud\Tiw\Requests\Parameters\StreamLayout;
use BiuBiuJun\QCloud\Tiw\Requests\SetOnlineRecordCallbackRequest;
use BiuBiuJun\QCloud\Tiw\Requests\StartOnlineRecordRequest;
use BiuBiuJun\QCloud\Tiw\Requests\StopOnlineRecordRequest;
use Closure;

class TiwRecord extends TiwClient
{
    /**
     * Handle online record callback notify.
     *
     * @param  \Closure  $closure
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidSignException
     */
    public function handleOnlineCallbackNotify(Closure $closure)
    {
        return $this->client->notify(OnlineRecordCallbackNotify::class, $closure);
    }

    /**
     * Set online record callback notify url.
     *
     * @param  string  $url
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function setOnlineCallback(string $url)
    {
        $request = new SetOnlineRecordCallbackRequest(config('qcloud.tim.sdk_app_id'), $url);
        $this->client->sendRequest($request);
    }

    /**
     * Start online record.
     *
     * @param  int  $roomId
     * @param  string  $teacherUuid
     * @param  bool  $isVideoCall
     * @return mixed
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function startOnlineRecord(int $roomId, string $teacherUuid, bool $isVideoCall = false)
    {
        $userId = "tic_record_user_{$roomId}_" . rand(10000, 99999);
        $userSign = $this->client->genUserSign($userId);
        $request = new StartOnlineRecordRequest(config('qcloud.tim.sdk_app_id'), $roomId, $userId, $userSign);

        $concat = new Concat(true);
        $request->setConcat($concat);

        $mixStream = new MixStream(true);
        $mixStream->setCustom($this->getCustomLayout($isVideoCall, $roomId, $teacherUuid));

        $request->setMixStream($mixStream);
        $request->setExtras(['MIX_STREAM']);

        $response = $this->client->sendRequest($request);

        return $response->getTaskId();
    }

    /**
     * Get Custom layout settings.
     *
     * @param  bool  $isVideoCall
     * @param  int  $roomId
     * @param  string  $teacherUuid
     * @return \BiuBiuJun\QCloud\Tiw\Requests\Parameters\CustomLayout
     */
    protected function getCustomLayout(bool $isVideoCall, int $roomId, string $teacherUuid)
    {
        $layout = true == $isVideoCall ? config('qcloud.vod.layout.split') : config('qcloud.vod.layout.full');

        // 设置画布
        $canvas = new Canvas(new LayoutParams($layout['canvas']['width'], $layout['canvas']['height']));
        // 白板
        $whiteboard = new StreamLayout(new LayoutParams(
            $layout['whiteboard']['width'],
            $layout['whiteboard']['height'],
            0,
            0,
            2
        ), 'tic_record_user');
        // 桌面分享
        $desktop = new StreamLayout(new LayoutParams(
            $layout['whiteboard']['width'],
            $layout['whiteboard']['height'],
            0,
            0,
            3
        ), 'desktop_sharing_' . $roomId);

        $inputStreamList = [
            $whiteboard->getParameters(),
            $desktop->getParameters(),
        ];

        if (true == $isVideoCall) {
            $tempVideoCallWidth = $layout['canvas']['width'] - $layout['whiteboard']['width'];
            $videoCallSize = $tempVideoCallWidth - ($tempVideoCallWidth * 0.2);

            $videoCallX = $layout['whiteboard']['width'] + ($tempVideoCallWidth * 0.1);
            $videoCallY = ($layout['canvas']['height'] - ($videoCallSize * 2)) / 3;

            $ticTeacher = new StreamLayout(new LayoutParams(
                $videoCallSize,
                $videoCallSize,
                $videoCallX,
                $videoCallY,
                1
            ), $teacherUuid);
            $ticStudent = new StreamLayout(new LayoutParams(
                $videoCallSize,
                $videoCallSize,
                $videoCallX,
                $videoCallY * 2 + $videoCallSize,
                1
            ));

            $inputStreamList[] = $ticTeacher->getParameters(false);
            $inputStreamList[] = $ticStudent->getParameters(false);
        } else {
            $ticTeacher = new StreamLayout(new LayoutParams(100, 100, 0, 0, 1), $teacherUuid);
            $ticStudent = new StreamLayout(new LayoutParams(100, 100, 100, 100, 1));

            $inputStreamList[] = $ticTeacher->getParameters(false);
            $inputStreamList[] = $ticStudent->getParameters(false);
        }

        return new CustomLayout($canvas, $inputStreamList);
    }

    /**
     * Stop online record.
     *
     * @param  string  $taskId
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function stopOnlineRecord(string $taskId)
    {
        $request = new StopOnlineRecordRequest(config('qcloud.tim.sdk_app_id'), $taskId);
        $this->client->sendRequest($request);
    }
}
