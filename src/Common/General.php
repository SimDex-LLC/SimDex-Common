<?php

namespace SimDex\Common;

class General
{
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

    public static function getPluginFileVersion(string $file_path)
    {
        $modified_timestamp = filemtime($file_path);
        $modified_date_time = date('Y-m-d-H-i-s', $modified_timestamp);

        return $modified_date_time;
    }
}
