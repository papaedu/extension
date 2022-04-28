<?php

namespace Papaedu\Extension\Payment\JdPay\Support;

class Sign
{
    protected array $ignores = [];

    protected array $result = [];

    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function encryptByXML(array $params): string
    {
        $string = XML::encode($params);
        $sha256String = hash('sha256', $string);

        return $this->withRSA($sha256String);
    }

    public function encrypt(array $params): string
    {
        ksort($params);

        $string = urldecode(http_build_query($params));
        $sha256String = hash('sha256', $string);

        return $this->withRSA($sha256String);
    }

    public function withRSA(string $data): string
    {
        $privateKey = openssl_pkey_get_private(file_get_contents($this->config['private_key_path']));
        $encrypted = '';
        openssl_private_encrypt($data, $encrypted, $privateKey, OPENSSL_PKCS1_PADDING);

        return base64_encode($encrypted);
    }

    public function validate(string $contents): bool
    {
        $xml = simplexml_load_string($contents);
        $encryptResult = json_decode(json_encode($xml), true);

        $encrypt = base64_decode($encryptResult['encrypt']);
        $key = base64_decode($this->config['tdes_key']);

        $tdes = new TDES();
        $resultString = $tdes->decrypt2Hex($encrypt, $key);

        $xml = simplexml_load_string($resultString);
        $result = json_decode(json_encode($xml), true);

        $startIndex = strpos($resultString, '<sign>');
        $endIndex = strpos($resultString, '</sign>');
        if ($startIndex != false && $endIndex != false) {
            $xmlStart = substr($resultString, 0, $startIndex);
            $xmlEnd = substr($resultString, $endIndex + 7, strlen($resultString));
            $resultString = $xmlStart.$xmlEnd;
        }

        $sha256String = hash('sha256', $resultString);

        $decrypt = $this->decrypt($result['sign']);

        $this->result = $result;

        return $decrypt == $sha256String;
    }

    public function decrypt(string $data): string
    {
        $publicKey = openssl_pkey_get_public(file_get_contents($this->config['public_key_path']));
        $decrypted = '';
        $data = base64_decode($data);

        openssl_public_decrypt($data, $decrypted, $publicKey);

        return $decrypted;
    }

    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return array
     */
    public function getIgnores(): array
    {
        return $this->ignores;
    }

    /**
     * @param  array  $ignores
     */
    public function setIgnores(array $ignores)
    {
        $this->ignores = $ignores;
    }
}
