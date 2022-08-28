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
 * Validation Class
 *
 * @category Validation
 * @package  SimDex\Commnon
 * @author   Geoff Myers <geoff@simdex.org>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU GPL 3.0
 * @link     https://github.com/SimDex-LLC/SimDex-Common
 */
class Validation
{
    /**
     * Validate email address
     *
     * @param mixed $value Email address to validate
     *
     * @return string|bool Valid email address or false if invalid
     */
    public static function validateEmail(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Validate domain name
     *
     * @param string $value Domain name to validate
     *
     * @return string|bool Valid domain name or false if invalid
     */
    public static function validateDomain(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_DOMAIN);
    }

    /**
     * Validate IP address (IPv4 or IPv6)
     *
     * @param mixed $value IP address to validate (IPv4 or IPv6)
     *
     * @return string Valid IP address or false if invalid
     */
    public static function validateIP(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_IP);
    }

    /**
     * Validate IPv4 address
     *
     * @param mixed $value IPv4 address to validate
     *
     * @return string|bool Valid IPv4 address or false if invalid
     */
    public static function validateIPv4(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }

    /**
     * Validate URL
     *
     * @param mixed $value URL to validate
     *
     * @return string|bool Valid URL or false if invalid
     */
    public static function validateURL(string $value): string|bool
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }
}
