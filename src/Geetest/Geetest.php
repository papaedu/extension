<?php

namespace Papaedu\Extension\Geetest;

use Illuminate\Support\Facades\Http;

class Geetest
{
    /**
     * @var string
     */
    const GT_SDK_VERSION = 'php_3.0.0';

    /**
     * @var array
     */
    private $response;

    /**
     * @var array
     */
    private $config;

    private $domain = 'http://api.geetest.com/';

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
    public function preProcess(array $param, int $newCaptcha = 1)
    {
        $data = array_merge([
            'gt' => $this->config['captcha_id'],
            'new_captcha' => $newCaptcha,
        ], $param);
        $challenge = Http::timeout(1)->get($this->domain.'register.php', $data)->body();
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
    private function successProcess($challenge)
    {
        $this->response = [
            'success' => 1,
            'gt' => $this->config['captcha_id'],
            'challenge' => md5($challenge.$this->config['captcha_key']),
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
            'gt' => $this->config['captcha_id'],
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
    public function getResponse()
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
    public function successValidate(string $challenge, string $validate, string $secCode, array $param, int $jsonFormat = 1)
    {
        if (!$this->checkValidate($challenge, $validate)) {
            return false;
        }

        $data = array_merge([
            'seccode' => $secCode,
            'timestamp' => time(),
            'challenge' => $challenge,
            'captchaid' => $this->config['captcha_id'],
            'json_format' => $jsonFormat,
            'sdk' => self::GT_SDK_VERSION,
        ], $param);
        $codeValidate = Http::timeout(1)->asForm()->post($this->domain.'validate.php', $data)->body();
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
    public function failValidate(string $challenge, string $validate, string $secCode)
    {
        return md5($challenge) == $validate;
    }

    /**
     * @param  string  $challenge
     * @param  string  $validate
     * @return bool
     */
    private function checkValidate(string $challenge, string $validate)
    {
        if (strlen($validate) != 32 || md5($this->config['captcha_key'].'geetest'.$challenge) != $validate) {
            return false;
        }

        return true;
    }

    /**
     * 一键登录
     *
     * @param  string  $processId
     * @param  string  $authCode
     * @param  string  $token
     * @return false|string
     */
    public function oneLoginCheckPhone(string $processId, string $authCode, string $token)
    {
        $data = [
            'process_id' => $processId,
            'token' => $token,
            'timestamp' => intval(microtime(true) * 1000),
        ];
        if ($authCode) {
            $data['authcode'] = $authCode;
        }
        $sign = hash_hmac('sha256', "{$this->config['one_login_id']}&&{$data['timestamp']}", $this->config['one_login_key'], true);
        $data['sign'] = bin2hex($sign);

        $url = 'https://onelogin.geetest.com/check_phone';
        $response = Http::timeout(1)->asJson()->post($url, $data);
        if (200 != $response->status()) {
            return false;
        }

        $result = $response->json();
        if (200 != $result['status']) {
            return false;
        }

        return $result['result'] ?? '';
    }
}
