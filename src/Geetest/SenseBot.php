<?php

namespace Papaedu\Extension\Geetest;

use Illuminate\Support\Facades\Http;

class SenseBot
{
    /**
     * @var string
     */
    public const GT_SDK_VERSION = 'php_3.0.0';

    /**
     * @var array
     */
    private array $response;

    /**
     * @var array
     */
    private array $config;

    /**
     * @var string
     */
    private string $domain = 'http://api.geetest.com/';

    private const TIMEOUT = 3;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * 判断极验服务器是否宕机
     *
     * @param  array  $param
     * @param  int  $newCaptcha
     * @return bool
     */
    public function preProcess(array $param, int $newCaptcha = 1): bool
    {
        $data = array_merge([
            'gt' => $this->config['app_id'],
            'new_captcha' => $newCaptcha,
        ], $param);
        $challenge = Http::timeout(self::TIMEOUT)->get($this->domain.'register.php', $data)->body();
        if (strlen($challenge) != 32) {
            $this->failbackProcess();

            return false;
        }
        $this->successProcess($challenge);

        return true;
    }

    /**
     * 正常模式处理
     *
     * @param  string  $challenge
     */
    private function successProcess(string $challenge)
    {
        $this->response = [
            'success' => 1,
            'gt' => $this->config['app_id'],
            'challenge' => md5($challenge.$this->config['key']),
            'new_captcha' => 1,
        ];
    }

    /**
     * 宕机模式处理
     */
    private function failbackProcess()
    {
        $rnd1 = md5(rand(0, 100));
        $rnd2 = md5(rand(0, 100));
        $challenge = $rnd1.substr($rnd2, 0, 2);
        $result = [
            'success' => 0,
            'gt' => $this->config['app_id'],
            'challenge' => $challenge,
            'new_captcha' => true,
        ];
        $this->response = $result;
    }

    /**
     * 返回数组结果
     *
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * 正常模式获取验证结果
     *
     * @param  string  $challenge
     * @param  string  $validate
     * @param  string  $secCode
     * @param  array  $param
     * @param  int  $jsonFormat
     * @return bool
     */
    public function successValidate(
        string $challenge,
        string $validate,
        string $secCode,
        array $param,
        int $jsonFormat = 1
    ): bool {
        if (! $this->checkValidate($challenge, $validate)) {
            return false;
        }

        $data = array_merge([
            'seccode' => $secCode,
            'timestamp' => time(),
            'challenge' => $challenge,
            'captchaid' => $this->config['app_id'],
            'json_format' => $jsonFormat,
            'sdk' => self::GT_SDK_VERSION,
        ], $param);
        $codeValidate = Http::timeout(self::TIMEOUT)->asForm()->post($this->domain.'validate.php', $data)->body();
        $obj = json_decode($codeValidate, true);
        if ($obj === false) {
            return false;
        }

        return $obj['seccode'] == md5($secCode);
    }

    /**
     * 宕机模式获取验证结果
     *
     * @param  string  $challenge
     * @param  string  $validate
     * @param  string  $secCode
     * @return bool
     */
    public function failValidate(string $challenge, string $validate, string $secCode): bool
    {
        return md5($challenge) == $validate;
    }

    /**
     * @param  string  $challenge
     * @param  string  $validate
     * @return bool
     */
    private function checkValidate(string $challenge, string $validate): bool
    {
        if (strlen($validate) != 32 || md5($this->config['key'].'geetest'.$challenge) != $validate) {
            return false;
        }

        return true;
    }
}
