<?php

require_once ROOT_DIR . '/engine/classes/smshop/include.php';
$main_table = 'fields';

$fields_form = [
    [
        "name"        => "Объект",
        "field"       => "item_type",
        "type"        => "select",
        "params"      => [
            "list" => [
                ['value' => "unknown", 'name' => "-"],
                ['value' => "shop_catalog", 'name' => "Каталог букетов"],
                ['value' => "shop_category", 'name' => "Категории"],
                ['value' => "shop_orders", 'name' => "Заказы"]
            ]
        ],
        "value"       => "catalog_auto",
        "layout_type" => "floating",
        "css_class"   => "col-6"
    ],
    [
        "name"        => "Группа",
        "field"       => "group_name",
        "type"        => "text",
        "layout_type" => "floating",
        "css_class"   => "col-6"
    ],
    [
        "name"        => "Поле (на латинице)",
        "field"       => "name",
        "type"        => "text",
        "layout_type" => "floating",
        "css_class"   => "col-4"
    ],
    [
        "name"        => "Название",
        "field"       => "label",
        "type"        => "text",
        "layout_type" => "floating",
        "css_class"   => "col-4"
    ],
    [
        "name"        => "Подсказка",
        "field"       => "placeholder",
        "type"        => "text",
        "layout_type" => "floating",
        "css_class"   => "col-4"
    ],
    [
        "name"        => "Тип поля",
        "field"       => "control_type",
        "type"        => "radio",
        "params"      => [
            "list" => [
                ['value' => "input", 'name' => "Текст"],
                ['value' => "textarea", 'name' => "Большой текст"],
                ['value' => "radio", 'name' => "Радио"],
                ['value' => "checkbox", 'name' => "Чекбоксы"],
                ['value' => "select", 'name' => "Список"],
                ['value' => "select_ajax", 'name' => "Список ajax"],
                ['value' => "upload_img", 'name' => "Изображение"],
                ['value' => "upload_img_gallery", 'name' => "Несколько изображений"],
            ]
        ],
        "layout_type" => "",
        "css_class"   => "col-6"
    ],
    [
        "name"        => "Параметры",
        "field"       => "control_params",
        "type"        => "textarea",
        "layout_type" => "floating",
        "css_class"   => "col-6"
    ],
    [
        "name"        => "Значение по умолчанию",
        "field"       => "default_value",
        "type"        => "text",
        "layout_type" => "floating",
        "css_class"   => "col-4"
    ],
    [
        "name"        => "Сортировка",
        "field"       => "sorter",
        "type"        => "text",
        "layout_type" => "floating",
        "css_class"   => "col-2"
    ],
    [
        "name"        => "Размер",
        "field"       => "size",
        "type"        => "text",
        "layout_type" => "floating",
        "css_class"   => "col-2"
    ],
    [
        "name"        => "В гриде",
        "field"       => "grid",
        "type"        => "checkbox",
        "layout_type" => "",
        "css_class"   => "col-2"
    ],
    [
        "name"        => "В форме",
        "field"       => "form",
        "type"        => "checkbox",
        "layout_type" => "",
        "css_class"   => "col-2"
    ],
];

if ($_REQUEST['act'] == 'settings') {


    $Res = [
        "stats"    => [],
        "informer" => [],
        "form"     => [
            "type"   => "modal", // modal row page
            "fields" => $fields_form,
        ],
        "grid"     => [
            "id"      => 'id',
            "columns" => [
                ["name" => "id", "field" => "id"],
                ["name" => "Поле", "field" => "name"],
                ["name" => "Название", "field" => "label"],
                ["name" => "Группа", "field" => "group_name"],
                ["name" => "Каталог", "field" => "item_type"],
                ["name" => "Сортировка", "field" => "sorter"],
                ["name" => "Размер", "field" => "size"],
                ["name" => "Тип поля", "field" => "control_type"],
            ],
            "sorter"  => [
                [
                    "field"     => "sorter",
                    "direction" => "ASC"
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
        "module"   => ['name' => $main_table, 'title' => 'Поля каталогов',],
        "api_url"  => "/api/v2/index.php?mod="
    ];
}

if ($_REQUEST['act'] === 'data') {
    $Res = [];
    if (!empty($req)) {
        $Fields = new Fields();
        $Res = $Fields->getList([], $req['pager'], $req['sorter']);
    }
}

if ($_REQUEST['act'] === 'item') {

    $Fields = new Fields();
    $data = $Fields->getItem($req['id']);


    $Res = [
        'data' => [
            'item'          => $data['item'],
            'item_settings' => [
                "allow_delete" => true,
                "allow_save"   => true,
                "fields"       => $fields_form,
                "type"         => "modal",
            ]
        ]
    ];
}

if ($_REQUEST['act'] == 'save') {
    $Res = [];
    if (!empty($req) and !empty($req['item'])) {
        $Fields = new Fields();
        $Res[] = $Fields->save($req['item']);
    }
}

if ($_REQUEST['act'] == 'delete') {
    $Res = [];
    if (!empty($req)) {
        if (!empty($req['id'])) {
            $Fields = new Fields();
            $Fields->delete((int)$req['id']);
            $Res = ['id' => 'deleted'];
        }
    }
}