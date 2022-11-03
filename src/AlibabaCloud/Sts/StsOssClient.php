<?php

namespace Papaedu\Extension\AlibabaCloud\Sts;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\MediaLibrary\Disk;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StsOssClient
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function assumeRole(string $bucket): array
    {
        $path1 = Disk::image()->getPreDir().Carbon::today()->format('Y/m/d');
        $path2 = Disk::image()->getPreDir().Carbon::tomorrow()->format('Y/m/d');

        try {
            $result = AlibabaCloud::rpc()
                ->product('Sts')
                ->version('2015-04-01')
                ->action('AssumeRole')
                ->method('POST')
                ->host('sts.aliyuncs.com')
                ->scheme('https')
                ->options([
                    'query' => [
                        'DurationSeconds' => 900,
                        'RegionId' => $this->config['region_id'],
                        'RoleArn' => $this->config['oss']['role_arn'],
                        'RoleSessionName' => $this->config['oss']['role_session_name'],
                        'Policy' => json_encode([
                            'Statement' => [
                                [
                                    'Action' => [
                                        'oss:PutObject',
                                    ],
                                    'Effect' => 'Allow',
                                    'Resource' => [
                                        "acs:oss:*:*:{$bucket}/{$path1}*",
                                        "acs:oss:*:*:{$bucket}/{$path2}*",
                                    ],
                                ],
                            ],
                            'Version' => '1',
                        ]),
                    ],
                ])
                ->request();

            return $result->toArray();
        } catch (ClientException|ServerException $e) {
            Log::error('Alibaba sts error.', [
                'code' => $e->getErrorCode(),
                'message' => $e->getErrorMessage(),
            ]);

            throw new HttpException(500, 'Internal Server Error');
        }
    }
}
