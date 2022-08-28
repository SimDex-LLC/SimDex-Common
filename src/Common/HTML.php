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
 * HTML Class
 *
 * @category HTML
 * @package  SimDex\Commnon
 * @author   Geoff Myers <geoff@simdex.org>
 * @license  https://www.gnu.org/licenses/gpl-3.0.html GNU GPL 3.0
 * @link     https://github.com/SimDex-LLC/SimDex-Common
 */
class HTML
{
    /**
     * Generate table styles HTML
     *
     * @return string Table styles HTML
     */
    public static function tableStyles(): string
    {
        $html = '
        <style>
            table, thead, tbody, tfoot, th, td {
                border: 1px solid #ccc;
                border-collapse: collapse;
                padding: 10px;
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            }

            th {
                font-weight: bold;
                background-color: #eee;
            }

            tr:hover {
                background-color: #eee;
            }
        </style>
        ';

        return $html;
    }

    /**
     * Generate table header HTML
     *
     * @param array       $headers       Array of table headers ($key => $label)
     * @param string|null $table_classes CSS classes for <table> tag
     * @param string|null $thead_classes CSS classes for <thead> tag
     *
     * @return string Table header HTML
     */
    public static function tableHeader(array $headers, ?string $table_classes = '', ?string $thead_classes = ''): string
    {
        $html = '
        <table class="' . htmlspecialchars($table_classes) . '">
            <thead class="' . htmlspecialchars($thead_classes) . '">
                <tr>
        ';

        foreach ($headers as $class => $header) {
            $html .= '<th class="' . htmlspecialchars($class) . '">' . $header . '</th>';
        }

        $html .= '
                </tr>
            </thead>
            <tbody>
        ';

        return $html;
    }

    /**
     * Generate table row HTML
     *
     * @param array $values Array of table column/cell values ($key => $value)
     *
     * @return string Table row HTML
     */
    public static function tableRow(array $values): string
    {
        $html = '<tr>';

        foreach ($values as $class => $value) {
            $html .= '<td class="' . htmlspecialchars($class) . '" data-value="' . htmlspecialchars($value) . '">' . $value . '</td>';
        }

        $html .= '</tr>';

        return $html;
    }

    /**
     * Generate table footer HTML
     *
     * @param array       $headers       Array of table headers ($key => $label)
     * @param string|null $tfoot_classes CSS classes for <tfoot> tag
     *
     * @return string Table footer HTML
     */
    public static function tableFooter(array $headers, ?string $tfoot_classes = ''): string
    {
        $html = '
        </tbody>
        <tfoot class="' . htmlspecialchars($tfoot_classes) . '">
            <tr>
        ';

        foreach ($headers as $class => $header) {
            $html .= '<th class="' . htmlspecialchars($class) . '">' . $header . '</th>';
        }

        $html .= '
                </tr>
            </tfoot>
        </table>
        ';

        return $html;
    }

    /**
     * Generate details table HTML
     *
     * @param array       $array         Array of table rows and columns ($label => $value)
     * @param string|null $table_classes CSS classes for <table> tag
     *
     * @return string Details table HTML
     */
    public static function detailsTable(array $array, ?string $table_classes = ''): string
    {
        $html = '
        <table class="' . htmlspecialchars($table_classes) . '">
            <tbody>
        ';

        foreach ($array as $label => $value) {
            if (!$value) {
                continue;
            }

            $html .= '
            <tr class="' . htmlspecialchars($label) . '">
                <th class="label" data-value="' . htmlspecialchars($label) . '">' . $label . '</th>
                <td class="value" data-value="' . htmlspecialchars($value) . '">' . $value . '</td>
            </tr>
            ';
        }

        $html .= '
            </tbody>
        </table>
        ';

        return $html;
    }

    /**
     * Generate list HTML
     *
     * @param array       $values       Array of list items
     * @param string|null $list_type    Type of list (default: ul)
     * @param string|null $list_classes CSS classes of <ul> or <ol> tag
     *
     * @return string List HTML
     */
    public static function list(array $values, ?string $list_type = 'ul', ?string $list_classes = ''): string
    {
        if ($list_type == 'ul') {
            $html = '<ul class="' . htmlspecialchars($list_classes) . '">';
        } elseif ($list_type == 'ol') {
            $html = '<ol class="' . htmlspecialchars($list_classes) . '">';
        }

        foreach ($values as $class => $value) {
            $html .= '<li class="' . htmlspecialchars($class) . '" data-value="' . htmlspecialchars($value) . '">' . $value . '</li>';
        }

        if ($list_type == 'ul') {
            $html .= '</ul>';
        } elseif ($list_type == 'ol') {
            $html .= '</ol>';
        }

        return $html;
    }

    /**
     * Generate form select options HTML
     *
     * @param array       $options  Array of select options ($value => $label)
     * @param string|null $default  Default option
     * @param string|null $selected Selected option
     *
     * @return string Form select options HTML
     */
    public static function formSelectOptions(array $options, ?string $default = '', ?string $selected = ''): string
    {
        $html = '';

        if (!$selected) {
            $selected = $default;
        }

        foreach ($options as $value => $label) {
            $value = htmlspecialchars($value);

            if ($selected && $selected == $value) {
                $html .= '<option class="option-selected" value="' . $value . '" selected>' . $label . '</option>' . PHP_EOL;
            } else {
                $html .= '<option value="' . $value . '">' . $label . '</option>' . PHP_EOL;
            }
        }

        return $html;
    }

    /**
     * Generate form checkbox fields HTML
     *
     * @param array       $checkboxes Array of checkbox fields ($value => $label)
     * @param string|null $name       Name of checkbox field
     * @param array|null  $default    Array of default checkboxes
     * @param array|null  $checked    Array of checked checkboxes
     *
     * @return string Form checkbox fields HTML
     */
    public static function formCheckboxFields(array $checkboxes, ?string $name, ?array $default = [], ?array $checked = []): string
    {
        $html = '';

        if (!$checked) {
            $checked = $default;
        }

        foreach ($checkboxes as $value => $label) {
            $value = htmlspecialchars($value);

            if ($checked && in_array($value, $checked)) {
                $html .= '<input type="checkbox" class="checkbox-checked" name="' . $name . '" id="' . $value . '" value="' . $value . '" checked>' . PHP_EOL;
            } else {
                $html .= '<input type="checkbox" name="' . $name . '" id="' . $value . '" value="' . $value . '">' . PHP_EOL;
            }

            $html .= '<label for="' . $name . '">' . $label . '</label>' . PHP_EOL;
        }

        return $html;
    }

    /**
     * Generate form radio button fields HTML
     *
     * @param array       $radio_buttons Array of radio button fields ($value => $label)
     * @param string|null $name          Name of radio button field group
     * @param array|null  $default       Default radio button
     * @param array|null  $checked       Checked radio button
     *
     * @return string Form radio button fields HTML
     */
    public static function formRadioButtonFields(array $radio_buttons, ?string $name, ?string $default = '', ?string $checked = ''): string
    {
        $html = '';

        if (!$checked) {
            $checked = $default;
        }

        foreach ($radio_buttons as $value => $label) {
            $name  = htmlspecialchars($name);
            $value = htmlspecialchars($value);

            if ($checked && $checked == $value) {
                $html .= '<input type="radio" class="radio-checked" name="' . $name . '" id="' . $value . '" value="' . $value . '" checked>' . PHP_EOL;
            } else {
                $html .= '<input type="radio" name="' . $name . '" id="' . $value . '" value="' . $value . '">' . PHP_EOL;
            }

            $html .= '<label for="' . $name . '">' . $label . '</label>' . PHP_EOL;
        }

        return $html;
    }
}
