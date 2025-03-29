<?php

$main_table = $module_name = 'shop_catalog';

if ($_REQUEST['act'] == 'settings') {

    $fields_group = $fields_form = [];
    $fields_grid = [];
    $table_fields = DbHelper::load_table_fields($main_table);
    foreach ($table_fields as $table_field)
        $fields_grid[] = ["name" => $table_field, "field" => $table_field];


    $fields = FieldsHelper::get($main_table);
    foreach ($fields as $field) {
        if ($field['form']) {
            $item = [
                "name"        => $field['label'],
                "field"       => $field['name'],
                "type"        => $field['control_type'],
                "layout_type" => (in_array($field['control_type'], ['text', 'input', 'textarea', 'select']) ? "floating" : ""),
                "css_class"   => 'col-md-' . $field['size']
            ];

            if ($field['default_value'] !== '')
                $item['value'] = $field['default_value'];


            if ($field['name'] == 'price')
                $item["disabled"] = true;

            if ($field['control_type'] === 'select' or $field['control_type'] === 'select_multi') {
                $name = explode('_', $field['name']);
                if ($name[0] == 'category') {
                    $Category = new Category('shop_category');
                    $list = $Category->getAsOptions(['parent_id' => (int)$name[1]], ['current' => 0, 'limit' => 100]);
                } else {
                    $list_rows = explode(PHP_EOL, $field['control_params']);
                    $list = [];
                    foreach ($list_rows as $list_row)
                        $list[] = ['name' => trim($list_row), 'value' => trim($list_row)];
                }

                $item['params'] = ["list" => $list];
            }

            if ($field['control_type'] === 'select_ajax')
                $item['params'] = ['url' => $field['control_params']];
            if ($field['control_type'] == 'module')
                $item['params'] = ["module_name" => $field['control_params']];

            if ($field['group_name'])
                $fields_group[$field['group_name']][] = $item;
            else
                $fields_form[] = $item;
        }
        if ($field['grid'])
            $fields_grid[] = ["name" => $field['label'], "field" => $field['name'], "type" => $field['control_type']];
    }

    foreach ($fields_group as $name => &$items)
        $items = ['name' => $name, 'fields' => $items];

    $Category = new Category('shop_category');

    $Res = [
        "stats"      => [],
        "informer"   => [],
        "form"       => [
            "type"         => "modal", // modal row page
            "fields"       => $fields_form,
            "fields_group" => array_values($fields_group),
            "allow_delete" => true,
            "allow_save"   => true,
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
                [
                    "title"        => "Тип композиции",
                    "type"         => "select",
                    "target_field" => "category_2",
                    "params"       => [
                        'list' => array_merge([['value' => "", 'name' => "Все"]],
                            $Category->getAsOptions(['parent_id' => 2], ['current' => 0, 'limit' => 100], [])
                        )
                    ],
                    "css_class"    => "col-2"
                ],
                [
                    "title"        => "Разбит",
                    "type"         => "select",
                    "target_field" => "composition_added",
                    "params"       => [
                        'list' => [
                            ['value' => "", 'name' => "Все"],
                            ['value' => "1", 'name' => "Да"],
                            ['value' => "-1", 'name' => "Нет"],
                        ]
                    ],
                    "css_class"    => "col-1"
                ],
                [
                    "title"        => "Опубликован",
                    "type"         => "select",
                    "target_field" => "composition_added",
                    "params"       => [
                        'list' => [
                            ['value' => "", 'name' => "Все"],
                            ['value' => "1", 'name' => "Да"],
                            ['value' => "-1", 'name' => "Нет"],
                        ]
                    ],
                    "css_class"    => "col-1"
                ],
            ]
        ],
        "module"     => ['name' => $module_name, 'title' => 'Каталог',],
        "api_url"    => "/api/v2/index.php?mod=",
        "upload_url" => 'https://' . $_SERVER['HTTP_HOST'] . "/engine/ajax/smshop/admin.php?mod=uploader",
    ];
}

if ($_REQUEST['act'] === 'data') {
    $Res = [];
    if (!empty($req)) {
        $Catalog = new Catalog($main_table);
        $Res = $Catalog->getList($req['filter'], $req['pager']);
    }
}

if ($_REQUEST['act'] === 'item') {
    $Catalog = new Catalog($main_table);
    $data = $Catalog->getItem($req['id']);

    $fields_form = [];
    $fields_group_ = [];

    $rows = FieldsHelper::get($main_table);
    foreach ($rows as $field) {
        $item = [
            "name"        => $field['label'],
            "field"       => $field['name'],
            "type"        => $field['control_type'],
            "layout_type" => (in_array($field['control_type'], ['text', 'input', 'textarea', 'select']) ? "floating" : ""),
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
            $fields_form[] = $item;
    }
    $fields_group = [];
    foreach ($fields_group_ as $name => $items)
        $fields_group[] = ['name' => $name, 'fields' => $items];

    $Res = [
        'data' => [
            'item'          => $data['item'],
            'item_settings' => null
        ]
    ];
}

if ($_REQUEST['act'] == 'save') {
    $Res = [];
    if (!empty($req) and !empty($req['item'])) {
        $Catalog = new Catalog($main_table);
        $Catalog->save($req['item']);
    }
}

if ($_REQUEST['act'] == 'delete') {
    $Res = [];
    if (!empty($req))
        if (!empty($req['id'])) {
            DbHelper::delete($main_table, "id='{$req['id']}'");
            DbHelper::delete('shop_catalog_composition', "parent_id='{$req['id']}'");
            $Res = ['id' => $req['id']];
        }
}
