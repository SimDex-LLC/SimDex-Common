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
}
