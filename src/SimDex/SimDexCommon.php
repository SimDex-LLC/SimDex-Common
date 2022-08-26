<?php

namespace SimDex;

class SimDexCommon
{
    public static function tableHeaderHTML(array $header_columns): string
    {
        $html = '
        <table>
            <thead>
                <tr>
        ';

        foreach ($header_columns as $class => $header_column) {
            $html .= '<th class="' . $class . '">' . $header_column . '</th>';
        }

        $html .= '
                </tr>
            </thead>
            <tbody>
        ';

        return $html;
    }

    public static function tableRowHTML(array $columns): string
    {

        $html = '<tr>';

        foreach ($columns as $class => $column) {
            $html .= '<td class="' . $class . '">' . $column . '</td>';
        }

        $html .= '</tr>';

        return $html;
    }

    public static function tableFooterHTML(array $footer_columns): string
    {
        $html = '
        </tbody>
        <tfoot>
            <tr>
        ';

        foreach ($footer_columns as $class => $footer_column) {
            $html .= '<th class="' . $class . '">' . $footer_column . '</th>';
        }

        $html .= '
                </tr>
            </tfoot>
        </table>
        ';

        return $html;
    }
}
