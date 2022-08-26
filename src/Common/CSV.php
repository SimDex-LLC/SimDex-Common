<?php

namespace SimDex\Common;

class CSV
{
    public static function load(string $file_path)
    {        
        $csv = array_map('str_getcsv', file($file_path));
        
        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        
        array_shift($csv);

        return $csv;
    }
}