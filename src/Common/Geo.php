<?php

namespace SimDex\Common;

class Geo
{
    private static function loadCSV(string $file_name): array
    {
        $file  = dirname(__FILE__, 3) . '/assets/' . $file_name;

        $csv = array_map('str_getcsv', file($file));

        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });

        array_shift($csv);

        return $csv;
    }

    public static function getStates(): array
    {
        $states = self::loadCSV('states.csv');

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
        $countries = self::loadCSV('countries.csv');

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
        $zip_codes = self::loadCSV('zip_codes.csv');

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
            if (defined('SIMDEX_IPGEOLOCATION_API_KEY')) {
                $api_key = SIMDEX_IPGEOLOCATION_API_KEY;
            } else {
                $api_key = 'b5469f65ca6d48ac9cea88d720d4e966';
            }

            $location_json = file_get_contents('https://api.ipgeolocation.io/ipgeo?apiKey=' . $api_key . '&ip=' . $ip_address, false, $context);
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
}
