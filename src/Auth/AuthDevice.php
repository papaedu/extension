<?php

namespace Papaedu\Extension\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Enums\Platform;
use Papaedu\Extension\Models\Device;

trait AuthDevice
{
    /**
     * @var int 获取用户设备并存储到数据库的设备ID
     */
    private int $deviceId;

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $loginType
     * @return \Papaedu\Extension\Models\Device
     */
    protected function saveDevice(Request $request, string $loginType): Device
    {
        $data = [
            'platform' => Platform::transform($request->header('platform')),
            'user_agent' => $request->header('user-agent'),
            'device_id' => $request->header('device-id'),
            'version' => $request->header('version'),
        ];

        if ($data['platform'] == Platform::IOS) {
            // 获取设备类型, 系统信息
            if (preg_match('/\(([^;]+);\s([^;]+);\s([^)]+)/isx', $data['user_agent'], $deviceInfo)) {
                [$_, $data['device_type'], $data['system']] = $deviceInfo;
            }
            $data['device_name'] = $request->header('device-name');
        } elseif ($data['platform'] == Platform::ANDROID) {
            // 获取系统信息, 设备名称
            if (preg_match('/\([^;]+;\s([^;]+);\s([^;]+);/isx', $data['user_agent'], $deviceInfo)) {
                [$_, $data['system'], $data['device_name']] = $deviceInfo;
            }
        }

        Log::info($loginType, $data);

        return Device::updateOrCreate([
            'device_id' => $request->header('device-id'),
        ], $data);
    }
}
