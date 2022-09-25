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
 * CSV Class
 *
 * @category CSV
 * @package  SimDex\Commnon
 * @author   Geoff Myers <geoff@simdex.org>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU GPL 3.0
 * @link     https://github.com/SimDex-LLC/SimDex-Common
 */
class CSV
{
    /**
     * Load CSV file
     *
     * @param string $file_path File path of CSV file
     *
     * @return array Array of CSV file contents
     */
    public static function load(string $file_path): array
    {
        $csv = array_map('str_getcsv', file($file_path));

        array_walk(
            $csv,
            function (&$a) use ($csv) {
                $a = array_combine($csv[0], $a);
            }
        );

        array_shift($csv);

        return $csv;
    }

    public static function toCSV(array $array_values, ?array $array_keys = [], ?string $delimiter = ',')
    {
        $csv = '';

        if (!$array_keys) {
            $first_row = reset($array_values);

            if (is_array($first_row) || is_object($first_row)) {
                $first_row = (array) $first_row;

                $array_keys = array_keys($first_row);
            }
        }

        if ($array_keys) {
            foreach ($array_keys as $key) {
                $csv .= $key . $delimiter;
            }

            $csv = substr($csv, 0, strlen($csv) - 1) . "\n";
        }

        foreach ($array_values as $row_key => $row) {
            foreach ($row as $column_key => $column) {
                $csv .= $column . $delimiter;
            }

            $csv = substr($csv, 0, strlen($csv) - 1) . "\n";
        }

        return $csv;
    }
}