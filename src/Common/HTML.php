<?php

namespace SimDex\Common;

class HTML
{
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

    public static function tableRow(array $values): string
    {

        $html = '<tr>';

        foreach ($values as $class => $value) {
            $html .= '<td class="' . htmlspecialchars($class) . '" data-value="' . htmlspecialchars($value) . '">' . $value . '</td>';
        }

        $html .= '</tr>';

        return $html;
    }

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

    public static function formSelectOptions(array $options, ?string $default = '', ?string $selected = ''): string
    {
        $html = '';

        foreach ($options as $value => $label) {
            $value = htmlspecialchars($value);

            if ($selected && $value == $selected) {
                $html .= '<option class="option-selected" value="' . $value . '" selected>' . $label . '</option>' . PHP_EOL;
            } elseif (!$selected && $value == $default) {
                $html .= '<option class="option-default-selected" value="' . $value . '" selected>' . $label . '</option>' . PHP_EOL;
            } else {
                $html .= '<option value="' . $value . '">' . $label . '</option>' . PHP_EOL;
            }
        }

        return $html;
    }

    public static function formCheckboxFields(array $checkboxes, ?array $default = [], ?array $checked = []): string
    {
        $html = '';

        foreach ($checkboxes as $value => $label) {
            $value = htmlspecialchars($value);

            if ($checked && in_array($value, $checked)) {
                if ($default && in_array($value, $default)) {
                    $html .= '<input type="checkbox" class="checkbox-checked checkbox-default" name="' . $value . '" id="' . $value . '" value="' . $value . '" checked>' . PHP_EOL;
                } else {
                    $html .= '<input type="checkbox" class="checkbox-checked" name="' . $value . '" id="' . $value . '" value="' . $value . '" checked>' . PHP_EOL;
                }
            } else {
                if ($default && in_array($value, $default)) {
                    $html .= '<input type="checkbox" class="checkbox-default" name="' . $value . '" id="' . $value . '" value="' . $value . '">' . PHP_EOL;
                } else {
                    $html .= '<input type="checkbox" name="' . $value . '" id="' . $value . '" value="' . $value . '">' . PHP_EOL;
                }
            }

            $html .= '<label for="' . $value . '">' . $label . '</label>' . PHP_EOL;
        }

        return $html;
    }

    public static function formRadioButtonFields(array $radio_buttons, ?string $name, ?string $default = '', ?string $checked = ''): string
    {
        $html = '';

        foreach ($radio_buttons as $value => $label) {
            $name  = htmlspecialchars($name);
            $value = htmlspecialchars($value);

            if ($checked && $checked == $value) {
                if ($default && $default == $value) {
                    $html .= '<input type="radio" class="radio-checked radio-default" name="' . $name . '" id="' . $value . '" value="' . $value . '" checked>' . PHP_EOL;
                } else {
                    $html .= '<input type="radio" class="radio-checked" name="' . $name . '" id="' . $value . '" value="' . $value . '" checked>' . PHP_EOL;
                }
            } else {
                if ($default && $default == $value) {
                    $html .= '<input type="radio" class="radio-default" name="' . $name . '" id="' . $value . '" value="' . $value . '">' . PHP_EOL;
                } else {
                    $html .= '<input type="radio" name="' . $name . '" id="' . $value . '" value="' . $value . '">' . PHP_EOL;
                }
            }

            $html .= '<label for="' . $value . '">' . $label . '</label>' . PHP_EOL;
        }

        return $html;
    }
}