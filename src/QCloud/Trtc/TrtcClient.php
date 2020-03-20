<?php

/*
 * This file is part of the papaedu/extension.
 *
 * (c) Pipi Zhang <zhangpipi.o3o@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Extension\QCloud\Trtc;

use BiuBiuJun\QCloud\QCloud;
use BiuBiuJun\QCloud\Trtc\Requests\DismissRoomRequest;
use BiuBiuJun\QCloud\Trtc\Requests\RemoveUserRequest;

class TrtcClient
{
    /**
     * @var \BiuBiuJun\QCloud\Trtc\TrtcClient
     */
    private $client;

    public function __construct()
    {
        $qCloud = new QCloud();
        $this->client = $qCloud->trtc(
            config('qcloud.tiw.secret_id'),
            config('qcloud.tiw.secret_key')
        );
    }

    /**
     * @return \BiuBiuJun\QCloud\Kernel\BaseResponse|\GuzzleHttp\Promise\PromiseInterface
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function dismissRoom(int $roomId)
    {
        $request = new DismissRoomRequest(config('qcloud.tim.sdk_app_id'), $roomId);

        return $this->client->sendRequest($request);
    }

    /**
     * @return \BiuBiuJun\QCloud\Kernel\BaseResponse|\GuzzleHttp\Promise\PromiseInterface
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function removeUser(int $roomId, array $userIds)
    {
        $request = new RemoveUserRequest(config('qcloud.tim.sdk_app_id'), $roomId, $userIds);

        return $this->client->sendRequest($request);
    }
}
