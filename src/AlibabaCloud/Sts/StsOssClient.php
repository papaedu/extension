<?php

namespace Papaedu\Extension\AlibabaCloud\Sts;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StsOssClient
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function assumeRole(string $bucket, int $expires = 900, array $paths = []): array
    {
        $resources = [];
        foreach ($paths as $path) {
            $resources[] = "acs:oss:*:*:{$bucket}/{$path}";
        }

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
                        'DurationSeconds' => max($expires, 900),// 不能小于900s
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
                                    'Resource' => $resources,
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
