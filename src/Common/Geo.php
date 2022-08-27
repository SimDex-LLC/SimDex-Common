<?php

namespace SimDex\Common;

class Geo
{
    private static function loadCSV(string $file_name): array
    {
        $file_path = dirname(__FILE__, 3) . '/assets/' . $file_name . '.csv';

        $csv = CSV::load($file_path);

        return $csv;
    }

    public static function getStates(): array
    {
        $states = self::loadCSV('states');

        return $states;
    }

    public static function getStateNames(): array
    {
        $states = self::getStates();

        $state_names = array_column($states, 'name');

        sort($state_names);

        return $state_names;
    }

    public static function getStateAbbreviations(): array
    {
        $states = self::getStates();

        $state_abbreviations = array_column($states, 'state');

        sort($state_abbreviations);

        return $state_abbreviations;
    }

    public static function getCountries(): array
    {
        $countries = self::loadCSV('countries');

        return $countries;
    }

    public static function getCountryNames(): array
    {
        $countries = self::getCountries();

        $country_names = array_column($countries, 'name');

        sort($country_names);

        return $country_names;
    }

    public static function getCountryAbbreviations(): array
    {
        $countries = self::getCountries();

        $country_abbreviations = array_column($countries, 'country');

        sort($country_abbreviations);

        return $country_abbreviations;
    }

    public static function getZIPCodes(): array
    {
        $zip_codes = self::loadCSV('zip_codes');

        return $zip_codes;
    }

    public static function getZIPCodeNumbers(): array
    {
        $zip_codes = self::getZIPCodes();

        $zip_code_numbers = array_column($zip_codes, 'zipcode');

        sort($zip_code_numbers);

        return $zip_code_numbers;
    }

    public static function getUserIPAddress()
    {
        if (isset($SERVER['HTTP_X_REAL_IP'])) {
            return $_SERVER['HTTP_X_REAL_IP'];
        } elseif (isset($SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($SERVER_['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    public static function getUserLocation(?string $field = '', ?string $api = 'ipgeolocation'): object|bool
    {
        $ip_address = self::getUserIPAddress();

        $context_options = [
            'http' => [
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ]
        ];

        $context = stream_context_create($context_options);

        if ($api == 'ipgeolocation') {
            $location_json = file_get_contents('https://api.ipgeolocation.io/ipgeo?apiKey=' . SIMDEX_IPGEOLOCATION_API_KEY . '&ip=' . $ip_address, false, $context);
        } elseif ($api == 'ipapi') {
            $location_json = file_get_contents('https://ipapi.co/' . $ip_address . '/json/', false, $context);
        } else {
            return false;
        }

        $location_object = json_decode($location_json);

        if ($field && isset($location_object->$field)) {
            return $location_object->$field;
        } else {
            return $location_object;
        }
    }

    public static function getDistance(float $lat1, float $lon1, float $lat2, float $lon2, ?string $unit = ''): float
    {
        $theta = $lon1 - $lon2;
        $dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist  = acos($dist);
        $dist  = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit  = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}
