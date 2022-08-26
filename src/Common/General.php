<?php

namespace SimDex\Common;

class General
{
    public static function boolToString(bool $boolean): string
    {
        if ($boolean) {
            return 'True';
        } else {
            return 'False';
        }
    }

    public static function boolToStringYesNo(bool $boolean): string
    {
        if ($boolean) {
            return 'Yes';
        } else {
            return 'No';
        }
    }

    public static function startTimer()
    {
        return hrtime(true);
    }

    public static function stopTimer($start_time)
    {
        $stop_time = hrtime(true);
        $duration  = ($stop_time - $start_time);
        $seconds   = ($duration / 1000000000);

        return $seconds;
    }

    public static function getFullURL()
    {
        if ($_SERVER['HTTPS'] && $_SERVER['HTTPS']) {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

        $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return $url;
    }

    public static function getFullURLNoQueryString(): string
    {
        $url = strtok($_SERVER['REQUEST_URI'], '?');

        return $url;
    }

    public static function getPluginFileVersion(string $file_path): string
    {
        $modified_timestamp = filemtime($file_path);
        $modified_date_time = date('Y-m-d-H-i-s', $modified_timestamp);

        return $modified_date_time;
    }
    

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
}
