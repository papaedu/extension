<?php

namespace Papaedu\Extension\Support;

use InvalidArgumentException;

/**
 * 参考项目
 * 1. https://github.com/wilon/php-number2chinese/blob/master/number2chinese.php
 * 2. Yurunsoft/ChineseUtil
 */
class Money
{
    private array $digital = ['零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖'];

    private array $counts = ['', '拾', '佰', '仟'];

    private array $counts4 = ['万', '亿', '兆', '垓', '穰', '涧', '载'];

    private array $units = ['元', '角', '分', '厘', '毫'];

    public static function toChinese($number): string
    {
        // 判断正确数字
        if (! preg_match('/^-?\d+(\.\d+)?$/', $number)) {
            throw new InvalidArgumentException('number2chinese() wrong number', 1);
        }
        [$integer, $decimal] = explode('.', $number.'.0');

        // 检测是否为负数
        $symbol = '';
        if (substr($integer, 0, 1) == '-') {
            $symbol = '负';
            $integer = substr($integer, 1);
        }
        if (preg_match('/^-?\d+$/', $number)) {
            $decimal = null;
        }
        $integer = ltrim($integer, '0');

        // 准备参数
        $numArr = ['', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖', '.' => '点'];
        $descArr = ['', '拾', '佰', '仟', '万', '拾', '佰', '仟', '亿', '拾', '佰', '仟', '万亿', '拾', '佰', '仟', '兆', '拾', '佰', '仟'];
        $rmbDescArr = ['角', '分', '厘', '毫'];

        // 整数部分拼接
        $integerRes = '';
        $count = strlen($integer);
        if ($count > max(array_keys($descArr))) {
            throw new InvalidArgumentException('number2chinese() number too large.', 1);
        } else {
            if ($count == 0) {
                $integerRes = '零';
            } else {
                for ($i = 0; $i < $count; $i++) {
                    $n = $integer[$i];      // 位上的数
                    $j = $count - $i - 1;   // 单位数组 $descArr 的第几位
                    // 零零的读法
                    $isLing = $i > 1                    // 去除首位
                        && $n !== '0'                   // 本位数字不是零
                        && $integer[$i - 1] === '0';    // 上一位是零
                    $cnZero = $isLing ? '零' : '';
                    $cnNum = $numArr[$n];
                    // 单位读法
                    $isEmptyDanwei = ($n == '0' && $j % 4 != 0)     // 是零且一断位上
                        || substr($integer, $i - 3, 4) === '0000';  // 四个连续0
                    $descMark = $cnDesc ?? '';
                    $cnDesc = $isEmptyDanwei ? '' : $descArr[$j];
                    // 第一位是一十
                    if ($i == 0 && $cnNum == '一' && $cnDesc == '十') {
                        $cnNum = '';
                    }
                    // 二两的读法
                    $isChangeEr = $n > 1 && $cnNum == '二'       // 去除首位
                        && ! in_array($cnDesc, ['', '十', '百'])  // 不读两\两十\两百
                        && $descMark !== '十';                   // 不读十两
                    if ($isChangeEr) {
                        $cnNum = '两';
                    }
                    $integerRes .= $cnZero.$cnNum.$cnDesc;
                }
            }
        }

        // 小数部分拼接
        $decimalRes = '';
        $count = strlen($decimal);
        if ($decimal === null) {
            $decimalRes = '整';
        } else {
            if ($decimal === '0') {
                $decimalRes = '';
            } else {
                if ($count > max(array_keys($descArr))) {
                    throw new InvalidArgumentException('number2chinese() number too large.', 1);
                } else {
                    for ($i = 0; $i < $count; $i++) {
                        if ($i > count($rmbDescArr) - 1) {
                            break;
                        }
                        $n = $decimal[$i];

                        // 零零的读法
                        $isLing = $i > 0                        // 去除首位
                            && $n !== '0'                       // 本位数字不是零
                            && $decimal[$i - 1] === '0';        // 上一位是零
                        $cnZero = $isLing ? '零' : '';
                        $cnNum = $numArr[$n];
                        $cnDesc = $cnNum ? $rmbDescArr[$i] : '';
                        $decimalRes .= $cnZero.$cnNum.$cnDesc;
                    }
                }
            }
        }

        // 拼接结果
        return $symbol.($integerRes.($decimalRes === '' ? '元整' : "元$decimalRes"));
    }

    public function toChineseBak($number): string
    {
        $number = 11001.01;

        if (preg_match('/^-?\d+(\.\d+)?$/', $number) <= 0) {
            throw new InvalidArgumentException(sprintf('%s is invalid.', $number));
        }

        // 处理正负数
        [$integer, $decimal] = explode('.', number_format($number, 4, '.', ''));
        $symbol = '';
        if ($integer < 0) {
            $symbol = '负';
            $integer = abs($integer);
        }

        if ($integer > 0) {
            return $symbol.$this->parseInteger($integer).$this->parseDecimal($decimal);
        } elseif (! $decimal) {
            return $this->digital[0].$this->units[0];
        } else {
            return $symbol.$this->parseDecimal($decimal);
        }
    }

    private function parseInteger($integer)
    {
        $integer = '10001000';

        if (0 == $integer) {
            return $this->digital[0];
        }

        $length = strlen($integer);

        $result = '';
        $countIndex = 0;
        $integer = strrev($integer);
        for ($i = 0; $i < $length; $i++) {
            if (0 != $integer[$i]) {
                $result = $this->digital[$integer[$i]].$this->counts[$i % 4].$result;
            } elseif (0 != $integer[$i - 1]) {
                $result = $this->digital[0].$result;
            }
            if (3 == $i % 4 && $length != $i + 1) {
                if (substr($integer, $i, 4) != '0000') {
                    $result = $this->counts4[$countIndex].$result;
                }
                $countIndex++;
            }
        }

        dd($result);

        $offset = $length & 3;
        $rightNumber = substr($integer, $offset);
        if ('' === $rightNumber || false === $rightNumber) {
            $split4 = [];
        } else {
            $split4 = str_split($rightNumber, 4);
        }
        if ($offset > 0) {
            array_unshift($split4, substr($integer, 0, $offset));
        }
        $split4Count = count($split4);

        $result = '';
        foreach ($split4 as $i => $item) {
            $length = strlen($item);

            $itemResult = '';
            for ($j = 0; $j < $length; $j++) {
                if ($j > 0 && 0 == $item[$j] && 0 == $item[$j - 1]) {
                    continue;
                }
                $itemResult .= $this->digital[$item[$j]];
                $countIndex = $length - $j - 2;
                if ($item[$j] && $countIndex >= 0) {
                    $itemResult .= $this->counts[$countIndex];
                }
                dump('---'.$result);
            }
            dump('a'.$itemResult);
            if ('0000' == $item) {
                $result = rtrim($result, $this->digital[0]);
                $result .= $this->digital[0];
                continue;
            }
            $itemResult = rtrim($itemResult, $this->digital[0]);
            $itemResult .= $this->counts4[$split4Count - $i - 1];
            dump('b'.$itemResult);
            $result .= $itemResult;
        }

        $result = rtrim($result, $this->digital[0]);
        $result .= $this->units[0];
        dd($result);

        return $result;
    }

    private function parseDecimal($number): string
    {
        if (0 == $number) {
            return '';
        }
        $result = '';
        $length = strlen($number);
        for ($i = 0; $i < $length; ++$i) {
            if (0 == $number[$i]) {
                $result .= $this->digital[$number[$i]];
            } else {
                $result .= $this->digital[$number[$i]].($this->units[$i + 1] ?? '');
            }
        }

        $ltrimResult = $this->mbLtrim($result, $this->digital[0]);
        dump($ltrimResult);
        dd($result);

        return '' === $ltrimResult || $ltrimResult === $result ? $ltrimResult : ($this->digital[0].$ltrimResult);
    }

    private function mbLtrim($string, $trim_chars = '\s')
    {
        return preg_replace('/^['.$trim_chars.']*(.*?)$/u', '\\1', $string);
    }

    public function mbRtrim($string, $trim_chars = '\s')
    {
        return preg_replace('/^(.*?)['.$trim_chars.']*$/u', '\\1', $string);
    }
}
