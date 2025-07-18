<?php

class DataTable
{
    public static function render($tableId, $options = [])
    {
        $defaultOptions = [
            'order' => [[1, 'asc']],
            'language' => [
                'paginate' => [
                    'previous' => '<i class="fas fa-chevron-left"></i>',
                    'next' => '<i class="fas fa-chevron-right"></i>',
                ]
            ],
            'pageLength' => 10,
            'initComplete' => self::rawJs("function() { $('#$tableId').css('visibility', 'visible'); }"),
            'columnDefs' => [
                'orderable' => false,
                'targets' => 'no-sort'
            ]
        ];

        $config = array_replace_recursive($defaultOptions, $options);

        // Encode the full config
        $json = json_encode($config, JSON_UNESCAPED_SLASHES);

        // Replace JS function markers
        $json = preg_replace_callback(
            '/"__FUNC__(.*?)__END__"/',
            function ($matches) {
                return html_entity_decode($matches[1]); // unquoted raw JS
            },
            $json
        );

        echo "<script>$(document).ready(function() { $('#$tableId').DataTable($json); });</script>" . self::style();
    }

    private static function rawJs($jsCode): string
    {
        return "__FUNC__{$jsCode}__END__";
    }

    private static function style(): string
    {
        return "
        <style>
            .sidebar {
                z-index: 1;
            }

            .dropdown-menu {
                z-index: 1050;
            }

            table.dataTable tbody th,
            table.dataTable tbody td {
                padding: 2px 2px;
            }

            table.dataTable>thead>tr>th,
            table.dataTable>thead>tr>td {
                padding: 1px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.3);
            }

            /* Reduce padding inside pagination buttons */
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 4px 8px;
                margin: 0 2px;
                font-size: 13px;
                min-width: 32px;
                /* keeps uniform clickable size */
            }

            /* Reduce spacing around the entire pagination container */
            .dataTables_wrapper .dataTables_paginate {
                margin-top: 10px;
                /* or less if you want tighter spacing */
            }

            #contactsTable {
                visibility: hidden;
            }

            #vehiclesTable {
                visibility: hidden;
            }
        </style>";
    }
}
