<?php

namespace Papaedu\Extension\Support;

use Illuminate\Support\Facades\Log;
use Papaedu\Extension\Facades\Response;
use Propaganistas\LaravelPhone\Exceptions\NumberParseException;
use Propaganistas\LaravelPhone\PhoneNumber;

class Phone
{
    /**
     * @param  string  $phoneNumber
     * @param  string  $country
     * @return int|null
     */
    public static function getCountryCode(string $phoneNumber, string $country): ?int
    {
        try {
            $phoneNumber = PhoneNumber::make($phoneNumber, $country);

            return $phoneNumber->getPhoneNumberInstance()->getCountryCode();
        } catch (NumberParseException $e) {
            Log::error($e, [
                'phone_number' => $phoneNumber,
                'country' => $country,
            ]);

            Response::errorBadRequest(trans('extension::validator.mobile_number_illegal'));
        }
    }
}
