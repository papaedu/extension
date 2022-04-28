<?php

namespace Papaedu\Extension\TencentCloud\Kernel\HttpClient;

use Papaedu\Extension\TencentCloud\Kernel\Contracts\RequestInterface;
use Papaedu\Extension\TencentCloud\Kernel\Contracts\TlsSignInterface;

/**
 * Class TlsHttpClient
 *
 * @package Papaedu\Extension\TencentCloud\Kernel\HttpClient
 */
class TlsHttpClient extends HttpClient
{
    /**
     * @var string
     */
    protected string $SDKAppID;

    /**
     * @var string
     */
    protected string $identifier;

    /**
     * @var string
     */
    protected string $userSign;

    /**
     * TlsHttpClient constructor.
     *
     * @param  string  $SDKAppID
     * @param  string  $identifier
     * @param  \Papaedu\Extension\TencentCloud\Kernel\Contracts\TlsSignInterface  $tlsSign
     * @param  string  $baseUri
     */
    public function __construct(string $SDKAppID, string $identifier, TlsSignInterface $tlsSign, string $baseUri)
    {
        $this->SDKAppID = $SDKAppID;
        $this->identifier = $identifier;
        $this->userSign = $tlsSign->sign($this->identifier);
        $this->baseUri = $baseUri;
    }

    /**
     * @param  \Papaedu\Extension\TencentCloud\Kernel\Contracts\RequestInterface  $request
     * @param  array  $options
     * @return array
     */
    protected function options(RequestInterface $request, array $options = [])
    {
        $result = array_filter([
            'query' => [
                'identifier' => $this->identifier,
                'sdkappid' => $this->SDKAppID,
                'random' => uniqid(),
                'contenttype' => 'json',
                'usersig' => $this->userSign,
            ],
            'json' => $request->getParameters(),
        ]);

        if ($options) {
            $result = array_merge($result, $options);
        }

        return $result;
    }
}
