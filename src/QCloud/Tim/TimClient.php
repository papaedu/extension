<?php

namespace Extension\QCloud\Tim;

use BiuBiuJun\QCloud\QCloud;
use BiuBiuJun\QCloud\Tim\Requests\GroupOpenHttpSvc\ModifyGroupMemberInfoRequest;

class TimClient
{
    /**
     * @var \BiuBiuJun\QCloud\Tim\TimClient
     */
    protected $client;

    public function __construct()
    {
        $qCloud = new QCloud();
        $this->client = $qCloud->tim(
            config('qcloud.tim.sdk_app_id'),
            config('qcloud.tim.identifier')
        );
        $this->client->setSignForHmac(config('qcloud.tim.key'));
    }

    /**
     * Get UserSign.
     *
     * @param  string  $identifier
     * @return string
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function getUserSign(string $identifier)
    {
        if (!$identifier) {
            return '';
        }

        return $this->client->genUserSign($identifier, config('jwt.refresh_ttl') * 60);
    }

    /**
     * Get PrivateMapKey.
     *
     * @param  string  $identifier
     * @param  string  $roomId
     * @param  int  $expire
     * @return string
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function getPrivateMapKey(string $identifier, string $roomId, int $expire = 300)
    {
        if (!$identifier || !$roomId) {
            return '';
        }

        return $this->client->genPrivateMapKey($identifier, $roomId, $expire);
    }

    /**
     * Set as administrator and give teacher role.
     *
     * @param  string  $groupId
     * @param  string  $memberAccount
     * @throws \BiuBiuJun\QCloud\Exceptions\BadRequestException
     * @throws \BiuBiuJun\QCloud\Exceptions\HttpException
     * @throws \BiuBiuJun\QCloud\Exceptions\InvalidArgumentException
     */
    public function setPermission(string $groupId, string $memberAccount)
    {
        $request = new ModifyGroupMemberInfoRequest($groupId, $memberAccount);
        $request->setRole('Admin');
        $request->setAppMemberDefinedData([
            [
                'Key' => 'identity',
                'Value' => 'teacher',
            ],
        ]);
        $this->client->sendRequest($request);
    }
}
