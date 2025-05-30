<?php

$main_table = $module_name = 'shop_catalog_composition';

if ($_REQUEST['act'] === 'settings') {

    $fields_group = $fields_form = [];
    $fields_grid = [];
    $table_fields = DbHelper::load_table_fields($main_table);
    foreach ($table_fields as $table_field) {
        if (in_array($table_field, ['date', 'sort', 'parent_id', 'user_id']))
            continue;
        $fields_grid[] = ["name" => $table_field, "field" => $table_field];
    }

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

            if ($field['control_type'] === 'select') {
                $list_rows = explode(PHP_EOL, $field['control_params']);
                $list = [];
                foreach ($list_rows as $list_row)
                    $list[] = ['name' => trim($list_row), 'value' => trim($list_row)];
                $item['params'] = ["list" => $list];
            }

            if ($field['control_type'] === 'select_ajax')
                $item['params'] = ['url' => $field['control_params']];

            if ($field['group_name'])
                $fields_group[$field['group_name']][] = $item;
            else
                $fields_form[] = $item;
        }
        if ($field['grid'])
            $fields_grid[] = ["name" => $field['label'], "field" => $field['name'], "type" => $field['control_type']];
    }

    $fields_grid[] = ["name" => 'Цена', "field" => 'price'];
    $fields_grid[] = ["name" => 'c/c', "field" => 'total_cost'];
    $fields_grid[] = ["name" => 'Итого', "field" => 'total'];


    foreach ($fields_group as $name => &$items)
        $items = ['name' => $name, 'fields' => $items];

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
            ]
        ],
        "module"     => ['name' => $module_name, 'title' => 'Состав', 'title_singular' => 'Составляющая {id} ',],
        "api_url"    => "/api/v2/index.php?mod=",
        "upload_url" => 'https://' . $_SERVER['HTTP_HOST'] . "/engine/ajax/smshop/admin.php?mod=uploader",
    ];
}

if ($_REQUEST['act'] === 'data') {
    $Res = [];
    if (!empty($req)) {
        $CatalogComposition = new CatalogComposition($main_table);

        $filter = ['parent_id' => $req['parent_id']];
        if ($req['parent_id'] == 0)
            $filter['user_id'] = $member_id['user_id'];

        $Res = $CatalogComposition->getList($filter, $req['pager']);

        $Res['totals'] = ['total' => 0, 'total_cost' => 0];
        foreach ($Res['data'] as &$item) {
            $item['composition_id'] = $item['title'];
            $Res['totals']['total'] += $item['total'];
            $Res['totals']['total_cost'] += $item['total_cost'];
        }

    }
}

if ($_REQUEST['act'] === 'item') {
    $CatalogComposition = new CatalogComposition($main_table);
    $data = $CatalogComposition->getItem($req['id']);

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

if ($_REQUEST['act'] === 'save') {
    $Res = [];
    if (!empty($req) and !empty($req['item'])) {
        $req['item']['parent_id'] = $req['parent_id'];
        $CatalogComposition = new CatalogComposition($main_table);
        $CatalogComposition->save($req['item']);
    }
}

if ($_REQUEST['act'] === 'delete') {
    $Res = [];
    if (!empty($req))
        if (!empty($req['id'])) {
            DbHelper::delete($main_table, "id='{$req['id']}'");
            $Res = ['id' => $req['id']];
        }
}
