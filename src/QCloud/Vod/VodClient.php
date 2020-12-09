<?php

namespace Extension\QCloud\Vod;

use BiuBiuJun\QCloud\QCloud;
use BiuBiuJun\QCloud\Vod\Constants\Media;
use BiuBiuJun\QCloud\Vod\Requests\ComposeMediaRequest;
use BiuBiuJun\QCloud\Vod\Requests\ConfirmEventsRequest;
use BiuBiuJun\QCloud\Vod\Requests\DeleteMediaRequest;
use BiuBiuJun\QCloud\Vod\Requests\DescribeMediaInfosRequest;
use BiuBiuJun\QCloud\Vod\Requests\ModifyMediaInfoRequest;
use BiuBiuJun\QCloud\Vod\Requests\Parameters\Output\ComposeMediaOutput;
use BiuBiuJun\QCloud\Vod\Requests\Parameters\Process\MediaProcessTaskInput;
use BiuBiuJun\QCloud\Vod\Requests\Parameters\Process\TaskInput\TranscodeTaskInput;
use BiuBiuJun\QCloud\Vod\Requests\Parameters\Track\MediaTrack;
use BiuBiuJun\QCloud\Vod\Requests\Parameters\Track\MediaTrackItem;
use BiuBiuJun\QCloud\Vod\Requests\Parameters\Track\VideoTrackItem;
use BiuBiuJun\QCloud\Vod\Requests\ProcessMediaRequest;
use BiuBiuJun\QCloud\Vod\Requests\PullEventsRequest;
use BiuBiuJun\QCloud\Vod\Requests\PullUploadRequest;
use Modules\Course\Enums\ClassType;

class VodClient
{
    /**
     * @var \BiuBiuJun\QCloud\Vod\VodClient
     */
    protected $client;

    public function __construct()
    {
        $qCloud = new QCloud();
        $this->client = $qCloud->vod(
            config('qcloud.vod.secret_id'),
            config('qcloud.vod.secret_key')
        );
    }

    /**
     * Upload video by pull method.
     *
     * @param  string  $mediaUrl
     * @param  string  $mediaName
     * @param  int  $categoryId
     * @param  int  $classType
     * @return array
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function pullUpload(string $mediaUrl, string $mediaName, int $categoryId, int $classType)
    {
        $request = new PullUploadRequest($mediaUrl);
        $request->setMediaName($mediaName);
        $request->setClassId($this->transCategoryIdToClassId($categoryId, $classType));
        /** @var \BiuBiuJun\QCloud\Vod\Responses\PullUploadResponse $response */
        $response = $this->client->sendRequest($request);

        return [
            'task_id' => $response->getTaskId(),
            'request_id' => $response->getRequestId(),
        ];
    }

    /**
     * @return \BiuBiuJun\QCloud\Kernel\BaseResponse
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function pullEvents()
    {
        $request = new PullEventsRequest();

        return $this->client->sendRequest($request, [
            'timeout' => 10,
        ]);
    }

    /**
     * @param  array  $evenHandles
     * @return string
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function confirmEvents(array $evenHandles)
    {
        $request = new ConfirmEventsRequest($evenHandles);
        /** @var \BiuBiuJun\QCloud\Vod\Responses\ConfirmEventsResponse $response */
        $response = $this->client->sendRequest($request);

        return $response->getRequestId();
    }

    /**
     * @param  string  $fileId
     * @param  array  $filters
     * @return \BiuBiuJun\QCloud\Kernel\BaseResponse|\GuzzleHttp\Promise\PromiseInterface
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function getMediaInfo(string $fileId, array $filters = [])
    {
        $request = new DescribeMediaInfosRequest([$fileId]);
        $request->setFilters($filters);

        return $this->client->sendRequest($request);
    }

    /**
     * @param  string  $fileId
     * @param  string  $description
     * @return \BiuBiuJun\QCloud\Kernel\BaseResponse|\GuzzleHttp\Promise\PromiseInterface
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function modifyMediaInfo(string $fileId, string $description)
    {
        $request = new ModifyMediaInfoRequest($fileId);
        $request->setDescription($description);

        return $this->client->sendRequest($request);
    }

    /**
     * @param  array  $fileIds
     * @param  string  $mediaName
     * @param  string  $mediaDescription
     * @param  int  $categoryId
     * @param  int  $classType
     * @return string
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function mergeMedia(
        array $fileIds,
        string $mediaName,
        string $mediaDescription,
        int $categoryId,
        int $classType
    ) {
        $mediaTrackItems = [];
        foreach ($fileIds as $fileId) {
            $mediaTrackItem = new MediaTrackItem(Media::TRACK_ITEM_TYPE_VIDEO);
            $mediaTrackItem->setVideoItem(new VideoTrackItem($fileId));

            $mediaTrackItems[] = $mediaTrackItem;
        }

        $track = new MediaTrack(Media::TRACK_TYPE_VIDEO, $mediaTrackItems);
        $output = new ComposeMediaOutput($mediaName);
        $output->setClassId($this->transCategoryIdToClassId($categoryId, $classType));
        $output->setDescription($mediaDescription);

        $request = new ComposeMediaRequest([$track], $output);
        /** @var \BiuBiuJun\QCloud\Vod\Responses\ComposeMediaResponse $response */
        $response = $this->client->sendRequest($request);

        return $response->getTaskId();
    }

    /**
     * @param  string  $fileId
     * @return string
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function deleteMedia(string $fileId)
    {
        $request = new DeleteMediaRequest($fileId);
        /** @var \BiuBiuJun\QCloud\Vod\Responses\DeleteMediaResponse $response */
        $response = $this->client->sendRequest($request);

        return $response->getRequestId();
    }

    /**
     * @param  string  $fileId
     * @return mixed
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function transcodeMedia(string $fileId)
    {
        $request = new ProcessMediaRequest($fileId);

        $transcodeTaskSet = new TranscodeTaskInput(59180);
        $mediaProcessTask = new MediaProcessTaskInput();
        $mediaProcessTask->setTranscodeTaskSet([$transcodeTaskSet]);

//        $adaptiveDynamicStreamingTaskSet = new AdaptiveDynamicStreamingTaskInput(10);
//        $mediaProcessTask->setAdaptiveDynamicStreamingTaskSet([$adaptiveDynamicStreamingTaskSet]);

        $request->setMediaProcessTask($mediaProcessTask);
        /** @var \BiuBiuJun\QCloud\Vod\Responses\ProcessMediaResponse $response */
        $response = $this->client->sendRequest($request);

        return $response->getTaskId();
    }

    /**
     * @param  int  $categoryId
     * @param  int  $classType
     * @return int
     */
    protected function transCategoryIdToClassId(int $categoryId, int $classType)
    {
        if ('production' != config('app.env')) {
            return 627197;
        }

        switch ($categoryId) {
            case 1:// 雅思
                $classId = ClassType::Personal == $classType ? 627179 : 627186;
                break;
            case 2:// 托福
                $classId = ClassType::Personal == $classType ? 627180 : 627187;
                break;
            case 3:// GRE
                $classId = ClassType::Personal == $classType ? 627182 : 627189;
                break;
            case 4:// GMAT
                $classId = ClassType::Personal == $classType ? 627181 : 627188;
                break;
            case 5:// 实用英语
                $classId = ClassType::Personal == $classType ? 627184 : 627191;
                break;
            case 6:// PTE
                $classId = ClassType::Personal == $classType ? 627183 : 627190;
                break;
            case 7:// 学术英语
                $classId = ClassType::Personal == $classType ? 627185 : 627192;
                break;
            default:
                $classId = 0;
        }

        return $classId;
    }
}
