<?php

namespace Extension\QCloud\Tiw;

use BiuBiuJun\QCloud\Tiw\Notifies\TranscodeCallbackNotify;
use BiuBiuJun\QCloud\Tiw\Requests\CreateTranscodeRequest;
use BiuBiuJun\QCloud\Tiw\Requests\SetTranscodeCallbackRequest;
use Closure;

class TiwTranscode extends TiwClient
{
    /**
     * Handle callback notify.
     *
     * @param  \Closure  $closure
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidSignException
     */
    public function handleCallbackNotify(Closure $closure)
    {
        return $this->client->notify(TranscodeCallbackNotify::class, $closure);
    }

    /**
     * Create transcode task.
     *
     * @param  string  $url
     * @return string
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function create(string $url)
    {
        $request = new CreateTranscodeRequest(config('qcloud.tim.sdk_app_id'), $url);
        $request->setIsStaticPpt(true);
        $response = $this->client->sendRequest($request);

        return $response->getTaskId();
    }

    /**
     * Set callback url.
     *
     * @param  string  $url
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function setCallback(string $url)
    {
        $request = new SetTranscodeCallbackRequest(config('qcloud.tim.sdk_app_id'), $url);
        $this->client->sendRequest($request);
    }
}
