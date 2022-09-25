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
 * General Class
 *
 * @category General
 * @package  SimDex\Commnon
 * @author   Geoff Myers <geoff@simdex.org>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU GPL 3.0
 * @link     https://github.com/SimDex-LLC/SimDex-Common
 */
class General
{
    /**
     * Boolean to True/False string
     *
     * @param mixed $boolean Boolean value
     *
     * @return string String value: "True" or "False"
     */
    public static function boolToString(bool $boolean): string
    {
        if ($boolean) {
            return 'True';
        } else {
            return 'False';
        }
    }

    /**
     * Boolean to Yes/No string
     *
     * @param mixed $boolean Boolean value
     *
     * @return string String value: "Yes" or "No"
     */
    public static function boolToStringYesNo(bool $boolean): string
    {
        if ($boolean) {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    /**
     * Start timer
     *
     * @return int|float Start time in nanoseconds
     */
    public static function startTimer(): int|float
    {
        return hrtime(true);
    }

    /**
     * Stop timer
     *
     * @param mixed $start_time Start time in nanoseconds
     *
     * @return int|float Timer duration in seconds
     */
    public static function stopTimer($start_time): int|float
    {
        $stop_time = hrtime(true);
        $duration  = ($stop_time - $start_time);
        $seconds   = ($duration / 1000000000);

        return $seconds;
    }

    /**
     * Get full URL
     *
     * @return string Full URL
     */
    public static function getFullURL(): string
    {
        if ($_SERVER['HTTPS'] && $_SERVER['HTTPS']) {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

        $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return $url;
    }

    /**
     * Get full URL without query string (alias function)
     *
     * @return string Full URL without query string
     */
    public static function getFullURLNoQueryString(): string
    {
        return self::getFullURLWithoutQueryString();
    }

    /**
     * Get full URL without query string
     *
     * @return string Full URL without query string
     */
    public static function getFullURLWithoutQueryString(): string
    {
        $url = strtok($_SERVER['REQUEST_URI'], '?');

        return $url;
    }

    /**
     * Get file last modified date/time string
     *
     * @param string $file_path Path to file
     *
     * @return string File last modified date/time
     */
    public static function getFileDateTime(string $file_path): string
    {
        $modified_timestamp = filemtime($file_path);
        $modified_date_time = date('Y-m-d-H-i-s', $modified_timestamp);

        return $modified_date_time;
    }

    /**
     * Generate PHP debug HTML output
     *
     * @return string PHP debug HTML
     */
    public static function debug(): string
    {
        $start_time = self::startTimer();

        $html = '
        <style>
            .simdex-debug {
                max-width: 1000px;
                overflow: auto;
                padding: 25px;
            }

            .simdex-debug pre {
                max-height: 500px;
                overflow: auto;
                padding: 25px;
                margin-top: 25px;
                margin-bottom: 25px;
                border: 1px solid #999;
                background-color: #eee;
            }

            .simdex-debug .php-info {
                max-height: 1000px;
                overflow: auto;
                border: 1px solid #999;
            }
        </style>
        ';

        $html .= '
        <h2>SimDex Debug</h2>
        <ul>
            <li><a href="#debug-php-request">PHP Request</a></li>
            <li><a href="#debug-php-cookie">PHP Cookie</a></li>
            <li><a href="#debug-php-session">PHP Session</a></li>
            <li><a href="#debug-php-server">PHP Server</a></li>
            <li><a href="#debug-php-settings">PHP Settings</a></li>
        </li>
        ';

        /* **************************************************
         * PHP
         * ************************************************** */

        $html .= '
        <a id="debug-php-request"><h3>PHP Request</h3></a>
        <pre>' . print_r($_REQUEST, true) . '</pre>
        <a id="debug-php-cookie"><h3>PHP Cookie</h3></a>
        <pre>' . print_r($_COOKIE, true) . '</pre>
        <a id="debug-php-session"><h3>PHP Session</h3></a>
        <pre>' . print_r($_SESSION, true) . '</pre>
        <a id="debug-php-server"><h3>PHP Server</h3></a>
        <pre>' . print_r($_SERVER, true) . '</pre>
        <a id="debug-php-settings"><h3>PHP Settings</h3></a>
        ';

        $html .= '<pre>';
        $html .= 'PHP Version: <strong>' . phpversion() . '</strong>' . PHP_EOL;
        $html .= 'PHP Memory Limit: <strong>' . ini_get('memory_limit') . '</strong>' . PHP_EOL;
        $html .= 'Display Errors: <strong>' . ini_get('display_errors') . '</strong>' . PHP_EOL;
        $html .= 'Error Log: <strong>' . ini_get('error_log') . '</strong>' . PHP_EOL;
        $html .= 'Error Reporting: <strong>' . ini_get('error_reporting') . '</strong>' . PHP_EOL;
        $html .= 'Max Execution Time: <strong>' . ini_get('max_execution_time') . ' seconds</strong>' . PHP_EOL;
        $html .= 'Max Input Time: <strong>' . ini_get('max_input_time') . ' seconds</strong>' . PHP_EOL;
        $html .= 'Max Input Variables: <strong>' . ini_get('max_input_vars') . '</strong>' . PHP_EOL;
        $html .= 'Open Base Dir: <strong>' . ini_get('open_basedir') . '</strong>' . PHP_EOL;
        $html .= 'Post Max Size: <strong>' . ini_get('post_max_size') . '</strong>' . PHP_EOL;
        $html .= 'Upload Max Filesize: <strong>' . ini_get('upload_max_filesize') . '</strong>' . PHP_EOL;
        $html .= '</pre>';

        $html .= '<p><a href="?debug=1&php_info=1">View All PHP Info</a></p>';

        if (isset($_GET['php_info']) && $_GET['php_info']) {
            $html = '<a id="debug-php-info"><h3>PHP Info</h3></a>';

            ob_start();
            phpinfo();
            $php_info = ob_get_contents();
            ob_get_clean();

            $html .= '<div class="php-info">' . $php_info . '</div>';
        }

        $seconds = self::stopTimer($start_time);

        $html .= '
            <p>Debug Execution Time: <strong>' . $seconds . ' seconds</strong></p>
        </div><!-- End .simdex-debug -->
        ';

        return $html;
    }

    public static function flattenAlt1(array $array)
    {
        $array_flat = [];

        array_walk_recursive($array, function ($a, $b) use (&$array_flat) {
            $array_flat[$b] = $a;
        });

        return $array_flat;
    }

    public static function flattenAlt2(array $array)
    {
        $array_flat = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array_flat = array_merge($array_flat, self::{__FUNCTION__}($value));
            } else {
                $array_flat = array_merge($array_flat, [$key => $value]);
            }
        }
        return $array_flat;
    }

    public static function flatten(array|object $array, ?string $separator = '.', ?string $prefix = '')
    {
        $array_flat = [];

        if (!is_array($array)) {
            $array = (array) $array;
        }

        foreach ($array as $key => $value) {
            $_key = ltrim($prefix . $separator . $key, $separator);

            if (is_array($value) || is_object($value)) {
                $array_flat = array_merge($array_flat, self::{__FUNCTION__}($value, $separator, $_key));
            } else {
                $array_flat[$_key] = $value;
            }
        }

        return $array_flat;
    }

    public static function flattenChildren(array $array, ?string $separator = '.', ?string $prefix = '')
    {
        $array_flat = [];

        foreach ($array as $key => $value) {
            $array_flat[$key] = self::flatten($value, $separator, $prefix);
        }

        return $array_flat;
    }
}