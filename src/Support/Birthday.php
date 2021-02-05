<?php

namespace Papaedu\Extension\Support;

use Carbon\Carbon;
use DateTimeInterface;

class Birthday
{
    /**
     * @var \Carbon\Carbon|null
     */
    private $birthday;

    /**
     * Birthday constructor.
     *
     * @param  string|null  $birthday
     */
    public function __construct(?string $birthday = null)
    {
        if ($birthday instanceof DateTimeInterface) {
            $this->birthday = $birthday;
        } elseif (!$birthday) {
            $this->birthday = null;
        } else {
            $this->birthday = Carbon::parse($birthday);
        }
    }

    /**
     * @param  string|null  $birthday
     * @return static
     */
    final public static function parse(?string $birthday = null): self
    {
        return new static($birthday);
    }

    /**
     * Get constellation for the birthday.
     *
     * @return string
     */
    public function constellation(): string
    {
        if (is_null($this->birthday)) {
            return '';
        }

        $constellations = ['摩羯座', '水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座', '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '摩羯座'];
        $days = [22, 20, 19, 21, 20, 21, 22, 23, 23, 23, 24, 23, 22];

        $index = $this->birthday->month;
        if ($this->birthday->day < $days[$this->birthday->month]) {
            $index--;
        }

        return $constellations[$index];
    }
}
