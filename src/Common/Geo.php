<?php
/**
 * SimDex Common
 * PHP Version 8.1
 *
 * @category Common
 * @package  SimDex\Commnon
 * @author   Geoff Myers <geoff@simdex.org>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU GPL 3.0
 * @link     https://github.com/SimDex-LLC/SimDex-Common
 */

namespace SimDex\Common;

/**
 * Geo Class
 *
 * @category Geo
 * @package  SimDex\Commnon
 * @author   Geoff Myers <geoff@simdex.org>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU GPL 3.0
 * @link     https://github.com/SimDex-LLC/SimDex-Common
 */
class Geo
{
    /**
     * Load CSV file
     *
     * @param mixed $file_name CSV file name without ".csv"
     *
     * @return array Array of CSV file contents
     */
    private static function _loadCSV(string $file_name): array
    {
        $file_path = dirname(__FILE__, 3) . '/assets/' . $file_name . '.csv';

        $csv = CSV::load($file_path);

        return $csv;
    }

    /**
     * Get all U.S. states
     *
     * @return array Array of all U.S. states
     */
    public static function getStates(): array
    {
        $states = self::_loadCSV('states');

        return $states;
    }

    /**
     * Get names of all U.S. states
     *
     * @return array Array of all U.S. state names
     */
    public static function getStateNames(): array
    {
        $states = self::getStates();

        $state_names = array_column($states, 'name');

        sort($state_names);

        return $state_names;
    }

    /**
     * Get abbreviations of all U.S. states
     *
     * @return array Array of all U.S. state abbreviations
     */
    public static function getStateAbbreviations(): array
    {
        $states = self::getStates();

        $state_abbreviations = array_column($states, 'state');

        sort($state_abbreviations);

        return $state_abbreviations;
    }

    /**
     * Get allc ountries
     *
     * @return array Array of all countries
     */
    public static function getCountries(): array
    {
        $countries = self::_loadCSV('countries');

        return $countries;
    }

    /**
     * Get all country names
     *
     * @return array Array of all country names
     */
    public static function getCountryNames(): array
    {
        $countries = self::getCountries();

        $country_names = array_column($countries, 'name');

        sort($country_names);

        return $country_names;
    }

    /**
     * Get all country abbreviations
     *
     * @return array Array of all country abbreviations
     */
    public static function getCountryAbbreviations(): array
    {
        $countries = self::getCountries();

        $country_abbreviations = array_column($countries, 'country');

        sort($country_abbreviations);

        return $country_abbreviations;
    }

    /**
     * Get all U.S. ZIP codes
     *
     * @return array Array of all U.S. ZIP codes
     */
    public static function getZIPCodes(): array
    {
        $zip_codes = self::_loadCSV('zip_codes');

        return $zip_codes;
    }

    /**
     * Get numbers of all U.S. ZIP codes
     *
     * @return array Array of all U.S. ZIP code numbers
     */
    public static function getZIPCodeNumbers(): array
    {
        $zip_codes = self::getZIPCodes();

        $zip_code_numbers = array_column($zip_codes, 'zipcode');

        sort($zip_code_numbers);

        return $zip_code_numbers;
    }

    /**
     * Get user's IP address
     *
     * @return string|bool User's IP address (IPv4 or IPv6)
     */
    public static function getUserIPAddress(): string|bool
    {
        if (isset($SERVER['HTTP_X_REAL_IP'])) {
            return $_SERVER['HTTP_X_REAL_IP'];
        } elseif (isset($SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($SERVER_['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        } else {
            return false;
        }
    }

    /**
     * Get user's geographic location
     *
     * @param string|null $field Name of field to return
     * @param string|null $api   Name of API to use (ipgeolocation or ipapi)
     *
     * @return string|object|bool User's geographic location
     */
    public static function getUserLocation(?string $field = '', ?string $api = 'ipgeolocation'): string|object|bool
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

    /**
     * Get distance between two geographic coordintes (latitude and longitude)
     *
     * @param float       $lat1 Latitude of first location
     * @param float       $lon1 Longitude of first location
     * @param float       $lat2 Latitude of second location
     * @param float       $lon2 Longitude of second location
     * @param string|null $unit Measurement unit (default: miles)
     *
     * @return float
     */
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
        } elseif ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}
