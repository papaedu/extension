<?php

namespace Papaedu\Extension\Payment\JdPay\Support;

use DOMDocument;

class XML
{
    /**
     * @param array $array
     * @param null $xml
     * @param null $node
     * @return string
     */
    public static function encode(array $array, $xml = null, $node = null)
    {
        if (is_null($xml)) {
            $xml = new DOMDocument('1.0', 'UTF-8');
        }
        if (is_null($node)) {
            $node = $xml->createElement('jdpay');
            $node = $xml->appendChild($node);
        }

        foreach ($array as $key => $value) {
            $nodeChild = $xml->createElement(is_string($key) ? $key : 'item');
            $nodeChild = $node->appendChild($nodeChild);
            if (!is_array($value)) {
                $text = $xml->createTextNode($value);
                $nodeChild->appendChild($text);
            } else {
                self::encode($value, $xml, $nodeChild);
            }
        }

        $string = $xml->saveXML();
        $string = str_replace("\r", '', $string);
        $string = str_replace("\n", '', $string);

        return $string;
    }

    public static function decode($xml)
    {
    }
}
