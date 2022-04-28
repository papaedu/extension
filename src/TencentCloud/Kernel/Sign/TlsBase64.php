<?php

namespace Papaedu\Extension\TencentCloud\Kernel\Sign;

use Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException;

/**
 * Trait TlsBase64
 *
 * @package Papaedu\Extension\TencentCloud\Kernel
 */
trait TlsBase64
{
    /**
     * @param  string  $string
     * @return string
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException
     */
    protected function base64Encode(string $string): string
    {
        $replace = ['+' => '*', '/' => '-', '=' => '_'];
        $base64 = base64_encode($string);
        if (false == $base64) {
            throw new InvalidSignException('base64_encode error');
        }

        return str_replace(array_keys($replace), array_values($replace), $base64);
    }

    /**
     * @param  string  $base64
     * @return string
     * @throws \Papaedu\Extension\TencentCloud\Exceptions\InvalidSignException
     */
    protected function base64Decode(string $base64): string
    {
        $replace = ['+' => '*', '/' => '-', '=' => '_'];
        $string = str_replace(array_values($replace), array_keys($replace), $base64);
        $result = base64_decode($string);
        if (false == $result) {
            throw new InvalidSignException('base64_decode error');
        }

        return $result;
    }
}
