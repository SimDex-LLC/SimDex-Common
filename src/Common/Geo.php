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
}
