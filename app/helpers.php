<?php

if (!function_exists('create_e164')) {
    /**
     * @param string $countryCode
     * @param string $phone
     * @return string
     */
    function create_e164($countryCode, $phone)
    {
        return '+' . $countryCode . $phone;
    }
}
