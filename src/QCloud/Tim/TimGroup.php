<?php

namespace Extension\QCloud\Tim;

use BiuBiuJun\QCloud\Exceptions\BadRequestException;
use BiuBiuJun\QCloud\Kernel\Contracts\CallbackInterface;
use BiuBiuJun\QCloud\Tim\Requests\GroupOpenHttpSvc\DeleteGroupMemberRequest;
use BiuBiuJun\QCloud\Tim\Requests\GroupOpenHttpSvc\GroupMsgGetSimpleRequest;
use GuzzleHttp\Pool;

class TimGroup extends TimClient
{
    const MSG_NUMBER = 20;

    /**
     * Get IM message.
     *
     * @param  string  $groupId
     * @param  \BiuBiuJun\QCloud\Kernel\Contracts\CallbackInterface  $callback
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function getMessages(string $groupId, CallbackInterface $callback)
    {
        $request = new GroupMsgGetSimpleRequest($groupId, self::MSG_NUMBER);
        $response = $this->client->sendRequest($request);

        if (!$response->isSuccessful()) {
            throw new BadRequestException('获取消息失败');
        }

        $nextMsgSeq = $callback->success($response);

        $requests = function ($msgSeq) use ($request) {
            while ($msgSeq > 1) {
                yield function () use ($request, $msgSeq) {
                    $request->setReqMsgSeq($msgSeq - 1);

                    return $this->client->sendRequest($request, [], true);
                };
                $msgSeq -= self::MSG_NUMBER;
            }
        };

        $pool = new Pool($this->client->getClient()->getHttpClient(), $requests($nextMsgSeq), [
            'concurrency' => 5,
            'fulfilled' => function ($resp, $index) use ($response, $callback) {
                $response->handle($resp);
                $callback->success($response);
            },
            'rejected' => function ($reason, $index) use ($response, $callback) {
                $callback->error($reason);
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
    }

    /**
     * Delete group members.
     *
     * @param  string  $groupId
     * @param  array  $members
     * @return \BiuBiuJun\QCloud\Kernel\BaseResponse|\GuzzleHttp\Promise\PromiseInterface
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function deleteGroupMember(string $groupId, array $members)
    {
        $request = new DeleteGroupMemberRequest($groupId, $members);

        return $this->client->sendRequest($request);
    }
}
