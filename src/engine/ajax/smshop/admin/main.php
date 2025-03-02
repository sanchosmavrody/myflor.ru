<?php

require_once ROOT_DIR . '/engine/classes/smshop/include.php';
$main_table = 'catalog_auto';

if ($_REQUEST['act'] == 'settings') {

    $fields_form = [];
    $fields_grid = [];
    $table_fields = DbHelper::load_table_fields($main_table);
    foreach ($table_fields as $table_field) {
        if ($table_field !== 'id')
            $fields_form[] = ["name"        => $table_field,
                              "field"       => $table_field,
                              "type"        => "text",
                              "layout_type" => "floating"];
        $fields_grid[] = ["name" => $table_field, "field" => $table_field];
    }

    $fields = FieldsHelper::get($main_table);
    foreach ($fields as $table_field) {
        if ($table_field['form'])
            $fields_form[] = ["name"        => $table_field['label'],
                              "field"       => $table_field['name'],
                              "type"        => $table_field['control_type'],
                              "layout_type" => (in_array($table_field['control_type'], ['text', 'input', 'textarea', 'select']) ? "floating" : "")
            ];
        if ($table_field['grid'])
            $fields_grid[] = ["name" => $table_field['label'], "field" => $table_field['name']];
    }

    $Res = [
        "stats"      => [],
        "informer"   => [],
        "form"       => [
            "type"   => "modal", // modal row page
            "fields" => $fields_form,
        ],
        "grid"       => [
            "id"      => 'id',
            "columns" => $fields_grid,
            "sorter"  => [
                [
                    "field"     => "id",
                    "direction" => "desc"
                ]
            ],
            "pager"   => [
                "current" => 0,
                "total"   => 0,
                "limit"   => 25,
            ],
            "filters" => [
                [
                    "title"        => "Поиск",
                    "type"         => "input",
                    "target_field" => "search_query",
                    "css_class"    => "col-4"
                ],
            ]
        ],
        "module"     => ['name' => 'main', 'title' => 'Каталог авто',],
        "api_url"    => "/api/v2/index.php?mod=",
        "upload_url" => 'https://' . $_SERVER['HTTP_HOST']
            . "/engine/ajax/smshop/admin.php?mod=uploader",
    ];
}

if ($_REQUEST['act'] === 'data') {
    $Res = [];
    if (!empty($req)) {
        $Catalog = new Catalog('catalog_auto');
        $Res = $Catalog->getList([], $req['pager']);
    }
}

if ($_REQUEST['act'] === 'item') {
    $Catalog = new Catalog('catalog_auto');
    $data = $Catalog->getItem($req['id']);

    $fields_group_ = [];
    $fields = [
        [
            "name"        => 'Создан',
            "field"       => 'date',
            "type"        => "datetime-local",
            "disabled"    => true,
            "layout_type" => "floating",
        ],
        //        [
        //            "name"        => 'Подмодуль',
        //            "field"       => 'sub_module_test',
        //            "type"        => "submodule",
        //            "params"      => $sub_module_params,
        //            "layout_type" => "floating",
        //        ]
    ];
    $rows = FieldsHelper::get('catalog_auto');
    foreach ($rows as $field) {
        $item = [
            "name"        => $field['label'],
            "field"       => $field['name'],
            "type"        => $field['control_type'],
            "layout_type" => (in_array($table_field['control_type'], ['text', 'input', 'textarea', 'select']) ? "floating" : ""),
            "css_class"   => "col-md-{$field['size']}",
            "params"      => ['url' => $field['control_params']],
        ];
        if ($field['control_type'] == 'select') {
            $list_rows = explode(PHP_EOL, $field['control_params']);
            $list = [];
            foreach ($list_rows as $list_row)
                $list[] = ['name' => trim($list_row), 'value' => trim($list_row)];
            $item['params'] = ["list" => $list];
        }
        if ($field['group_name'])
            $fields_group_[$field['group_name']][] = $item;
        else
            $fields[] = $item;
    }
    $fields_group = [];
    foreach ($fields_group_ as $name => $items)
        $fields_group[] = ['name' => $name, 'fields' => $items];

    $Res = [
        'data' => [
            'item'          => $data['item'],
            'item_settings' => [
                "allow_delete" => true,
                "allow_save"   => true,
                "fields"       => $fields,
                "fields_group" => $fields_group,
                "type"         => "modal",
            ]
        ]
    ];
}

if ($_REQUEST['act'] == 'save') {
    $Res = [];
    if (!empty($req) and !empty($req['item'])) {
        $Catalog = new Catalog($main_table);
        $Res[] = $Catalog->save($req['item']);
    }
}
