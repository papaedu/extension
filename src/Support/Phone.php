<?php

namespace Papaedu\Extension\Support;

use Propaganistas\LaravelPhone\PhoneNumber;

class Phone
{
    /**
     * Exchange ISO code to IDD code.
     *
     * @param  string  $phoneNumber
     * @param  string  $ISOCode
     * @return int|null
     */
    public static function ISOCode2IDDCode(string $phoneNumber, string $ISOCode): ?int
    {
        $phoneNumber = PhoneNumber::make($phoneNumber, $ISOCode);

        return $phoneNumber->getPhoneNumberInstance()->getCountryCode();
    }
}
