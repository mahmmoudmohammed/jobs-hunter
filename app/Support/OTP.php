<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class OTP
{
    /**
     * generate otp code
     *
     * @param string $key
     * @param string $value
     *
     * @return string[]|null
     */
    public static function generate(string $key, string $value): ?array
    {
        $otpCode = rand(100000, 999999);
        $data['otpCode'] = $otpCode;
        Cache::put($key . ':' . $value, $data, now()->addMinutes(15));
        return Cache::get($key . ':' . $value);
    }

    /**
     * get otp code from cache
     *
     * @param string $key
     * @param string $value
     * @return array|null
     */
    public static function get(string $key, string $value): ?array
    {
        return Cache::get($key . ':' . $value);
    }

    /**
     * Check similarity of key and code from cache
     *
     * @param string $key
     * @param string $value
     * @param string $code
     * @return bool
     */
    public static function check(string $key, string $value,string $code):bool
    {
        $cashCode = OTP::get($key, $value)['otpCode'] ?? '';
        if ($cashCode != $code) {
            return false;
        }
        return true;
    }
}
