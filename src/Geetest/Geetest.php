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
        $response = Http::timeout(1)->get($this->domain . 'register.php', array_merge([
            'gt' => $this->config['captcha_id'],
            'new_captcha' => $newCaptcha,
        ], $param));
        $challenge = $response->body();

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
     * @param $challenge
     */
    private function successProcess($challenge)
    {
        $this->response = [
            'success' => 1,
            'gt' => $this->config['captcha_id'],
            'challenge' => md5($challenge . $this->config['private_key']),
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
        $challenge = $rnd1 . substr($rnd2, 0, 2);
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
            "seccode" => $secCode,
            "timestamp" => time(),
            "challenge" => $challenge,
            "captchaid" => $this->config['captcha_id'],
            "json_format" => $jsonFormat,
            "sdk" => self::GT_SDK_VERSION,
        ], $param);
        $codeValidate = Http::post('http://api.geetest.com/validate.php', $data);
        $obj = json_decode($codeValidate, true);
        if ($obj === false) {
            return false;
        }

        return $obj['seccode'] == md5($secCode);
    }

    /**
     * 宕机模式获取验证结果
     *
     * @param $challenge
     * @param $validate
     * @param $secCode
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
        if (strlen($validate) != 32 || md5($this->config['private_key'] . 'geetest' . $challenge) != $validate) {
            return false;
        }

        return true;
    }

    /**
     * @param $err
     */
    private function triggerError($err)
    {
        trigger_error($err);
    }

    public function oneLoginCheckPhone($processId, $authCode, $token)
    {
        $query = [
            'process_id' => $processId,
            'token' => $token,
            'timestamp' => intval(microtime(true) * 1000),
        ];
        if ($authCode) {
            $query['authcode'] = $authCode;
        }
        $sign = hash_hmac('sha256', "{$this->appId}&&{$query['timestamp']}", $this->appKey, true);
        $query['sign'] = bin2hex($sign);

        $url = 'https://onelogin.geetest.com/check_phone';
        $result = $this->postRequest($url, $query, true);
        \Log::info('geetest response:' . $result);
        $result = \GuzzleHttp\json_decode($result, true);

        return $result['result'] ?? '';
    }
}
