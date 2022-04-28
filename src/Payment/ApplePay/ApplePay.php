<?php

namespace Papaedu\Extension\Payment\ApplePay;

use Illuminate\Support\Facades\Http;
use Papaedu\Extension\Exceptions\InvalidArgumentException;

class ApplePay
{
    protected string $sandbox = 'https://sandbox.itunes.apple.com/verifyReceipt';

    protected string $production = 'https://buy.itunes.apple.com/verifyReceipt';

    private bool $isSandbox;

    public function __construct()
    {
        $this->isSandbox = config('payment.apple_pay.is_sandbox', false);
    }

    /**
     * @param  string  $receiptData
     * @return array
     * @throws \Papaedu\Extension\Exceptions\InvalidArgumentException
     */
    public function verifyReceipt(string $receiptData): array
    {
        $data = $this->sendReceipt($receiptData);

        if ($data['status'] === 21007) {
            $this->isSandbox = true;

            return $this->verifyReceipt($receiptData);
        } elseif ($data['status'] !== 0) {
            throw new InvalidArgumentException($this->getStatusError($data['status']));
        }

        return $data;
    }

    /**
     * @param $receiptData
     * @return array
     */
    protected function sendReceipt($receiptData): array
    {
        $url = $this->isSandbox ? $this->sandbox : $this->production;
        $response = Http::post($url, [
            'receipt-data' => $receiptData,
        ]);

        return $response->json();
    }

    /**
     * @param $status
     * @return string
     */
    private function getStatusError($status): string
    {
        switch (intval($status)) {
            case 21000:
                $error = 'Apple Store不能读取你提供的JSON对象';
                break;
            case 21002:
                $error = 'receipt-data域的数据有问题';
                break;
            case 21003:
                $error = 'receipt无法通过验证';
                break;
            case 21004:
                $error = '提供的shared secret不匹配你账号中的shared secret';
                break;
            case 21005:
                $error = 'receipt服务器当前不可用';
                break;
            case 21006:
                $error = 'receipt合法，但是订阅已过期';
                break;
            case 21007:
                $error = 'receipt是沙盒凭证，但却发送至生产环境的验证服务';
                break;
            case 21008:
                $error = 'receipt是生产凭证，但却发送至沙盒环境的验证服务';
                break;
            default:
                $error = '支付结果异常-未知错误';
        }

        return $error;
    }
}
