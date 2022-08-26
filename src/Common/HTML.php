<?php

namespace SimDex\Common;

class HTML
{
    public static function tableHeader(array $headers, ?string $table_classes = '', ?string $thead_classes = ''): string
    {
        $html = '
        <table class="' . $table_classes . '">
            <thead class="' . $thead_classes . '">
                <tr>
        ';

        foreach ($headers as $class => $header) {
            $html .= '<th class="' . $class . '">' . $header . '</th>';
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
            $html .= '<td class="' . $class . '" data-value="' . htmlspecialchars($value) . '">' . $value . '</td>';
        }

        $html .= '</tr>';

        return $html;
    }

    public static function tableFooter(array $headers, ?string $tfoot_classes = ''): string
    {
        $html = '
        </tbody>
        <tfoot class="' . $tfoot_classes . '">
            <tr>
        ';

        foreach ($headers as $class => $header) {
            $html .= '<th class="' . $class . '">' . $header . '</th>';
        }

        $html .= '
                </tr>
            </tfoot>
        </table>
        ';

        return $html;
    }

    public static function list(array $values, ?string $list_type = 'ul', ?string $list_classes = ''): string
    {

        if ($list_type == 'ul') {
            $html = '<ul class="' . $list_classes . '">';
        } elseif ($list_type == 'ol') {
            $html = '<ol class="' . $list_classes . '">';
        }

        foreach ($values as $class => $value) {
            $html .= '<li class="' . $class . '" data-value="' . htmlspecialchars($value) . '">' . $value . '</li>';
        }

        if ($list_type == 'ul') {
            $html .= '</ul>';
        } elseif ($list_type == 'ol') {
            $html .= '</ol>';
        }

        return $html;
    }
}
