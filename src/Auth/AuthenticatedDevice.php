<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Http\Request;
use Laravel\Sanctum\NewAccessToken;
use Papaedu\Extension\Enums\Header;
use Papaedu\Extension\Enums\Platform;
use Papaedu\Extension\Models\Device;

trait AuthenticatedDevice
{
    /**
     * @var int 获取用户设备并存储到数据库的设备ID
     */
    private int $deviceId;

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Sanctum\NewAccessToken  $accessToken
     * @return void
     */
    protected function bindingDevice(Request $request, NewAccessToken $accessToken): void
    {
        $platform = platform();
        if (! Platform::isBindingDevice($platform)) {
            return;
        }

        $data = [
            'platform' => $platform,
            'user_agent' => $request->header(Header::USER_AGENT->value, ''),
            'app_name' => $request->header(Header::APP_NAME->value, ''),
            'version' => $request->header(Header::VERSION->value, ''),
        ];
        $this->handleDeviceInfo($data, $request);

        $device = Device::updateOrCreate([
            'device_id' => $request->header(Header::DEVICE_ID->value, ''),
        ], $data);

        $request->user()->devices()->attach($device->id, ['token_id' => $accessToken->accessToken->id]);
    }

    /**
     * @param $data
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function handleDeviceInfo(&$data, Request $request): void
    {
        if ($data['platform'] == Platform::IOS) {
            // 获取设备类型, 系统信息
            if (preg_match('/\(([^;]+);\s([^;]+);\s([^)]+)/ix', $data['user_agent'], $deviceInfo)) {
                [$_, $data['device_type'], $data['system']] = $deviceInfo;
            }
            $data['device_name'] = $request->header(Header::DEVICE_NAME->value);
        } elseif ($data['platform'] == Platform::ANDROID) {
            // 获取系统信息, 设备名称
            if (preg_match('/\([^;]+;\s([^;]+);\s([^;]+);/ix', $data['user_agent'], $deviceInfo)) {
                [$_, $data['system'], $data['device_name']] = $deviceInfo;
            }
        }
    }
}
