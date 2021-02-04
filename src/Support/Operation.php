<?php

namespace Papaedu\Extension\Support;

class Operation
{
    /**
     * ID转换与运算值(2的$id-1次方)
     *
     * @param  int  $id
     * @return int
     */
    public static function idToAndValue(int $id): int
    {
        return $id > 0 ? (int)pow(2, ($id - 1)) : 0;
    }

    /**
     * ID数组转换与运算
     *
     * @param  array  $ids
     * @return int
     */
    public static function idsToAndValue(array $ids): int
    {
        $andValue = 0;

        foreach ($ids as $id) {
            $andValue += self::idToAndValue($id);
        }

        return $andValue;
    }

    /**
     * 与运算转换ID数组
     *
     * @param  int  $andValueTotal
     * @return array
     */
    public static function andValueTotalToIds(int $andValueTotal): array
    {
        $ids = [];
        $array = str_split(strrev(decbin($andValueTotal)));
        foreach ($array as $key => $value) {
            if (1 == $value) {
                $ids[] = $key + 1;
            }
        }

        return $ids;
    }

    /**
     * ID是否在与运算值内
     *
     * @param  int  $id
     * @param  int  $andValueTotal
     * @return bool
     */
    public static function idInAndValueTotal(int $id, int $andValueTotal): bool
    {
        $andValue = self::idToAndValue($id);

        return (intval($andValue) & intval($andValueTotal)) == intval($andValue);
    }

    /**
     * 与运算值增加ID
     *
     * @param  int  $id
     * @param  int  $andValueTotal
     * @return int
     */
    public static function andValuePlusId(int $id, int $andValueTotal): int
    {
        if (!self::idInAndValueTotal($id, $andValueTotal)) {
            $andValueTotal += self::idToAndValue($id);
        }

        return $andValueTotal;
    }

    /**
     * 与运算值减少ID
     *
     * @param  int  $id
     * @param  int  $andValueTotal
     * @return int
     */
    public static function andValueMinusId(int $id, int $andValueTotal): int
    {
        if (self::idInAndValueTotal($id, $andValueTotal)) {
            $andValueTotal -= self::idToAndValue($id);
        }

        return $andValueTotal;
    }
}
