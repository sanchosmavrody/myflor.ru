<?php

$main_table = $module_name = 'shop_composition';

if ($_REQUEST['act'] === 'settings') {

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
        "module"     => ['name' => $module_name, 'title' => 'Составляющие',],
        "api_url"    => "/api/v2/index.php?mod=",
        "upload_url" => 'https://' . $_SERVER['HTTP_HOST'] . "/engine/ajax/smshop/admin.php?mod=uploader",
    ];
}

if ($_REQUEST['act'] === 'data') {
    $Res = [];
    if (!empty($req)) {
        $Catalog = new Composition($main_table);
        $Res = $Catalog->getList($req['filter'], $req['pager']);
    }
}

if ($_REQUEST['act'] === 'item') {
    $Catalog = new Composition($main_table);
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
        $Catalog = new Composition($main_table);
        $Res[] = $Catalog->save($req['item']);
    }
}

if ($_REQUEST['act'] == 'delete') {
    $Res = [];
    if (!empty($req))
        if (!empty($req['id'])) {
            $req['id'] = DbHelper::delete($main_table, "id='{$req['id']}'");
            $Res = ['id' => $req['id']];
        }
}

if ($_REQUEST['act'] == 'import') {
    $Res = [];
    $items = array(
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Кения одн. 40 см (А1)',
            'cost'          => 39,
            'price'         => 78,
            'bitrix_id'     => 302
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Кения одн. 50 см Микс',
            'cost'          => 53,
            'price'         => 106,
            'bitrix_id'     => 303
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Кустовая голландия 6\7',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 304
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Эквадор Нина Giron 60 см алая',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 305
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Ирис Синий',
            'cost'          => 46,
            'price'         => 92,
            'bitrix_id'     => 306
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Тюльпан Голландский (гладкий)',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 307
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Тюльпан пионовидный Фокстрот (розово-белый)',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 308
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хризантема Бакарди Ромашка',
            'cost'          => 105,
            'price'         => 210,
            'bitrix_id'     => 309
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хризантема Гранд Пинк',
            'cost'          => 105,
            'price'         => 210,
            'bitrix_id'     => 310
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Альстромерия Колумбия Фунза',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 311
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Альстромерия Эквадор',
            'cost'          => 105,
            'price'         => 210,
            'bitrix_id'     => 312
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гипсофила 60 см',
            'cost'          => 90,
            'price'         => 180,
            'bitrix_id'     => 313
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Салал',
            'cost'          => 80,
            'price'         => 160,
            'bitrix_id'     => 314
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Анемон (красный)',
            'cost'          => 99,
            'price'         => 198,
            'bitrix_id'     => 315
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гвоздика диантус',
            'cost'          => 48,
            'price'         => 96,
            'bitrix_id'     => 316
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Эустома лизиантус Голл.',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 317
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Подсолнух',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 318
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Ранункулюс',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 319
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хамелациум',
            'cost'          => 145,
            'price'         => 290,
            'bitrix_id'     => 320
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Эвкалипт Парвифолия (1/5)',
            'cost'          => 190,
            'price'         => 313,
            'bitrix_id'     => 321
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Эвкалипт Цинерия',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 322
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Эквадор 60 см Микс',
            'cost'          => 125,
            'price'         => 250,
            'bitrix_id'     => 323
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка шляпная XL (h25-d30)',
            'cost'          => 635,
            'price'         => 1270,
            'bitrix_id'     => 324
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка шляпная L (h20-d25)',
            'cost'          => 630,
            'price'         => 1260,
            'bitrix_id'     => 325
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка шляпная M (h23-d20)',
            'cost'          => 310,
            'price'         => 650,
            'bitrix_id'     => 326
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка шляпная S (h18-d16)',
            'cost'          => 200,
            'price'         => 400,
            'bitrix_id'     => 327
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Корзина белая L 41-41-16',
            'cost'          => 950,
            'price'         => 2050,
            'bitrix_id'     => 329
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Корзина белая М 36-34-14',
            'cost'          => 950,
            'price'         => 1900,
            'bitrix_id'     => 330
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Корзина белая S 31-27-12',
            'cost'          => 750,
            'price'         => 1500,
            'bitrix_id'     => 331
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Ящик с ручкой M 30-33-10,5',
            'cost'          => 550,
            'price'         => 1100,
            'bitrix_id'     => 332
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Ящик с ручкой S 26-28-8,5',
            'cost'          => 200,
            'price'         => 500,
            'bitrix_id'     => 333
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка прямоугольная с бантом L 40-24-11',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 334
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка прямоугольная с бантом М 37-21-10',
            'cost'          => 270,
            'price'         => 540,
            'bitrix_id'     => 335
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка прямоугольная с бантом S 34-184-9',
            'cost'          => 170,
            'price'         => 320,
            'bitrix_id'     => 336
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Матовый картон',
            'cost'          => 20,
            'price'         => 100,
            'bitrix_id'     => 338
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Бумага тишью',
            'cost'          => 7,
            'price'         => 25,
            'bitrix_id'     => 339
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Лен искусственный',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 340
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Мешковина',
            'cost'          => 100,
            'price'         => 200,
            'bitrix_id'     => 341
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Сизаль',
            'cost'          => 50,
            'price'         => 150,
            'bitrix_id'     => 343
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Фетр',
            'cost'          => 20,
            'price'         => 50,
            'bitrix_id'     => 344
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Пленка',
            'cost'          => 25,
            'price'         => 55,
            'bitrix_id'     => 345
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Пленка сложная',
            'cost'          => 40,
            'price'         => 100,
            'bitrix_id'     => 346
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Лента атлас',
            'cost'          => 6,
            'price'         => 30,
            'bitrix_id'     => 347
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Лента кружево',
            'cost'          => 20,
            'price'         => 60,
            'bitrix_id'     => 348
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар сердце фольга маленький',
            'cost'          => 10,
            'price'         => 50,
            'bitrix_id'     => 350
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар сердце фольга большой',
            'cost'          => 50,
            'price'         => 400,
            'bitrix_id'     => 351
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гиперикум',
            'cost'          => 130,
            'price'         => 260,
            'bitrix_id'     => 373
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Орхидея Дендробиум',
            'cost'          => 100,
            'price'         => 200,
            'bitrix_id'     => 374
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лимониум',
            'cost'          => 124,
            'price'         => 248,
            'bitrix_id'     => 375
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Орхидея Цимбидиум',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 376
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Эвкалипт Беби Блю',
            'cost'          => 190,
            'price'         => 380,
            'bitrix_id'     => 377
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Эвкалипт Популус',
            'cost'          => 190,
            'price'         => 68,
            'bitrix_id'     => 378
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза НГ 40 см',
            'cost'          => 40,
            'price'         => 80,
            'bitrix_id'     => 379
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза тепличная (50 см)',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 380
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 1 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 402
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 2 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 403
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 3 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 404
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 4 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 405
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 5 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 406
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 6 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 407
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 7 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 408
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 8 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 409
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 9 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 410
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Цифра 0 (40х102 см)',
            'cost'          => 100,
            'price'         => 590,
            'bitrix_id'     => 411
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар круг, С ДНЕМ РОЖДЕНИЯ (18`/46 СМ)',
            'cost'          => 75,
            'price'         => 300,
            'bitrix_id'     => 412
        ),
        array(
            'category_name' => 'Шары',
            'title'         => '"Шар Звезда, С ДНЕМ РОЖДЕНИЯ (18`/45см)"',
            'cost'          => 50,
            'price'         => 400,
            'bitrix_id'     => 413
        ),
        array(
            'category_name' => 'Шары',
            'title'         => '"Шар Мишка с сердечком (40`)',
            'cost'          => 120,
            'price'         => 450,
            'bitrix_id'     => 414
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар сердце (45 см)',
            'cost'          => 50,
            'price'         => 400,
            'bitrix_id'     => 415
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар сердце маленькое (12,5 см)',
            'cost'          => 10,
            'price'         => 50,
            'bitrix_id'     => 416
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Пион Coral Сharm',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 442
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Пион Сара Бернар (Sarah Bernhardt)',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 443
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Писташ',
            'cost'          => 30,
            'price'         => 60,
            'bitrix_id'     => 444
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Ящик с ручкой L 30-38-20',
            'cost'          => 550,
            'price'         => 1100,
            'bitrix_id'     => 451
        ),
        array(
            'category_name' => 'Вазы',
            'title'         => 'Ваза (стекло h21-d13 см)',
            'cost'          => 160,
            'price'         => 500,
            'bitrix_id'     => 456
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Плюшевый медведь (60 см)',
            'cost'          => 1050,
            'price'         => 3900,
            'bitrix_id'     => 461
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Плюшевый медведь S (35 см стоя)',
            'cost'          => 350,
            'price'         => 1100,
            'bitrix_id'     => 464
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Плюшевый медведь L (60 см стоя)',
            'cost'          => 950,
            'price'         => 2500,
            'bitrix_id'     => 469
        ),
        array(
            'category_name' => 'Топперы',
            'title'         => 'Топпер',
            'cost'          => 30,
            'price'         => 150,
            'bitrix_id'     => 471
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Кашпо с ручкой Family S',
            'cost'          => 200,
            'price'         => 400,
            'bitrix_id'     => 525
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Кашпо с ручкой Family M',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 526
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Кашпо с ручкой Family L',
            'cost'          => 485,
            'price'         => 970,
            'bitrix_id'     => 527
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Кашпо с ручкой Family XL',
            'cost'          => 750,
            'price'         => 1500,
            'bitrix_id'     => 528
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Сизаль абака',
            'cost'          => 45,
            'price'         => 150,
            'bitrix_id'     => 531
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Крафт',
            'cost'          => 30,
            'price'         => 100,
            'bitrix_id'     => 532
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гербера',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 533
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Аспидистра',
            'cost'          => 33,
            'price'         => 66,
            'bitrix_id'     => 534
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза желтая Penny Lane (50 см)',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 535
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза розовая Анкор 50 см',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 536
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза красная Гран При (50 см)',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 537
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза белая (50 см)',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 540
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гвоздика кустовая',
            'cost'          => 55,
            'price'         => 103,
            'bitrix_id'     => 563
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хризантема Балтика',
            'cost'          => 105,
            'price'         => 210,
            'bitrix_id'     => 564
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза кустовая пионовидная (50 см)',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 565
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Пионовидная роза Red Piano',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 566
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Рускус',
            'cost'          => 45,
            'price'         => 90,
            'bitrix_id'     => 567
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гортензия',
            'cost'          => 230,
            'price'         => 460,
            'bitrix_id'     => 568
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Фоамиран',
            'cost'          => 55,
            'price'         => 110,
            'bitrix_id'     => 578
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Конверт коробка',
            'cost'          => 151,
            'price'         => 302,
            'bitrix_id'     => 579
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хризантема мини',
            'cost'          => 73,
            'price'         => 146,
            'bitrix_id'     => 586
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза красная Гран При (70 см)',
            'cost'          => 79,
            'price'         => 158,
            'bitrix_id'     => 625
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза кустовая красная',
            'cost'          => 130,
            'price'         => 260,
            'bitrix_id'     => 626
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Фрезия',
            'cost'          => 88,
            'price'         => 176,
            'bitrix_id'     => 639
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Вероника',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 641
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка шляпная XS (h11-d10)',
            'cost'          => 175,
            'price'         => 450,
            'bitrix_id'     => 667
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Ромашка полевая (Танацетум)',
            'cost'          => 88,
            'price'         => 176,
            'bitrix_id'     => 670
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза тепличная (70 см)',
            'cost'          => 79,
            'price'         => 158,
            'bitrix_id'     => 671
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза тепличная (40 см)',
            'cost'          => 53,
            'price'         => 106,
            'bitrix_id'     => 681
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза тепличная (60 см)',
            'cost'          => 75,
            'price'         => 150,
            'bitrix_id'     => 692
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза мента 40 см',
            'cost'          => 53,
            'price'         => 136,
            'bitrix_id'     => 724
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Набор Фонтан из 14 шаров',
            'cost'          => 150,
            'price'         => 1500,
            'bitrix_id'     => 738
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Мишка Ted микс (25 см)',
            'cost'          => 230,
            'price'         => 750,
            'bitrix_id'     => 742
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'Конфета Raffaello',
            'cost'          => 18,
            'price'         => 50,
            'bitrix_id'     => 746
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка с бантом With Love',
            'cost'          => 325,
            'price'         => 650,
            'bitrix_id'     => 747
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза кустовая (70 см)',
            'cost'          => 200,
            'price'         => 400,
            'bitrix_id'     => 749
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Статица',
            'cost'          => 104,
            'price'         => 208,
            'bitrix_id'     => 751
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар 1 сентября',
            'cost'          => 5,
            'price'         => 150,
            'bitrix_id'     => 766
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Кот Basik&Co',
            'cost'          => 800,
            'price'         => 1600,
            'bitrix_id'     => 791
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хризантема (одноголовая)',
            'cost'          => 160,
            'price'         => 320,
            'bitrix_id'     => 832
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар Хром 30 см',
            'cost'          => 7,
            'price'         => 200,
            'bitrix_id'     => 843
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар латекс микс',
            'cost'          => 4,
            'price'         => 150,
            'bitrix_id'     => 844
        ),
        array(
            'category_name' => 'Подарки',
            'title'         => 'Мягкая игрушка Basik&Co Кот Басик (22 см)',
            'cost'          => 280,
            'price'         => 560,
            'bitrix_id'     => 857
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Мягкая игрушка зайка',
            'cost'          => 250,
            'price'         => 800,
            'bitrix_id'     => 864
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Зайка Ми-ми(25 см)',
            'cost'          => 250,
            'price'         => 900,
            'bitrix_id'     => 930
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хлопок',
            'cost'          => 25,
            'price'         => 90,
            'bitrix_id'     => 942
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Конверт для цветочных композиций',
            'cost'          => 151,
            'price'         => 400,
            'bitrix_id'     => 962
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Брассика',
            'cost'          => 102,
            'price'         => 204,
            'bitrix_id'     => 973
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Краспедия',
            'cost'          => 39,
            'price'         => 78,
            'bitrix_id'     => 980
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лилия',
            'cost'          => 390,
            'price'         => 780,
            'bitrix_id'     => 983
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лапник',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 989
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Ёлочный шар',
            'cost'          => 20,
            'price'         => 100,
            'bitrix_id'     => 994
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Эрингиум',
            'cost'          => 113,
            'price'         => 226,
            'bitrix_id'     => 1015
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Скимия',
            'cost'          => 95,
            'price'         => 190,
            'bitrix_id'     => 1016
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Протея',
            'cost'          => 650,
            'price'         => 1300,
            'bitrix_id'     => 1038
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хасмантиум',
            'cost'          => 40,
            'price'         => 80,
            'bitrix_id'     => 1039
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лаванда (пучок малый)',
            'cost'          => 130,
            'price'         => 260,
            'bitrix_id'     => 1048
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Мимоза',
            'cost'          => 550,
            'price'         => 1100,
            'bitrix_id'     => 1051
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Коробка трапеция 27-15-9',
            'cost'          => 173,
            'price'         => 500,
            'bitrix_id'     => 1109
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Нарцисс',
            'cost'          => 86,
            'price'         => 172,
            'bitrix_id'     => 1132
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза тепличная (80 см)',
            'cost'          => 99,
            'price'         => 198,
            'bitrix_id'     => 1170
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Пшеница',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 1183
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Душица',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 1219
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лимонник',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 1220
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лагурус (15шт пучок)',
            'cost'          => 188,
            'price'         => 376,
            'bitrix_id'     => 1224
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Перо',
            'cost'          => 40,
            'price'         => 200,
            'bitrix_id'     => 1240
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'Жевательная резинка Love is (пачка)',
            'cost'          => 186,
            'price'         => 550,
            'bitrix_id'     => 1248
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Кашпо Love is',
            'cost'          => 165,
            'price'         => 500,
            'bitrix_id'     => 1252
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Корзина XXL',
            'cost'          => 4000,
            'price'         => 5500,
            'bitrix_id'     => 1260
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Бессмертник',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 1267
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Единорог плюшевый 25 см',
            'cost'          => 180,
            'price'         => 1000,
            'bitrix_id'     => 1269
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Форма для композиций единорог',
            'cost'          => 300,
            'price'         => 600,
            'bitrix_id'     => 1276
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза стабилизорованная',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 1277
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Макарун',
            'cost'          => 90,
            'price'         => 180,
            'bitrix_id'     => 1282
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Драже Несквик (100 гр.)',
            'cost'          => 170,
            'price'         => 340,
            'bitrix_id'     => 1287
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Драже Миндаль/Апельсин/Корица (100 гр.)',
            'cost'          => 186,
            'price'         => 372,
            'bitrix_id'     => 1288
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Карамель сливочно-соленая (190 мл.)',
            'cost'          => 160,
            'price'         => 320,
            'bitrix_id'     => 1289
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Карамель Маракуя (190 мл.)',
            'cost'          => 160,
            'price'         => 320,
            'bitrix_id'     => 1290
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Карамель Лаванда (190 мл.)',
            'cost'          => 160,
            'price'         => 320,
            'bitrix_id'     => 1291
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Пион из белого шоколада',
            'cost'          => 70,
            'price'         => 180,
            'bitrix_id'     => 1292
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Плитка из темного шоколада (105 гр.)',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 1293
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Кейкпопс Шоколадный',
            'cost'          => 70,
            'price'         => 140,
            'bitrix_id'     => 1294
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка для макарун (6 шт.)',
            'cost'          => 20,
            'price'         => 40,
            'bitrix_id'     => 1301
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка для макарун (12 шт.)',
            'cost'          => 30,
            'price'         => 60,
            'bitrix_id'     => 1302
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Кейкпопс Ванильный',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 1309
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Зайка Ми',
            'cost'          => 800,
            'price'         => 1600,
            'bitrix_id'     => 1316
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза одноголовая пионовидная 40 см',
            'cost'          => 80,
            'price'         => 160,
            'bitrix_id'     => 1330
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Шляпная Коробка М (20 см) короткая',
            'cost'          => 200,
            'price'         => 500,
            'bitrix_id'     => 1341
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар подсолнух (70 см)',
            'cost'          => 45,
            'price'         => 250,
            'bitrix_id'     => 1347
        ),
        array(
            'category_name' => 'Шары',
            'title'         => '"Фонтан воздушных шаров 12"" ""Без фильтров"", 5 шт."',
            'cost'          => 50,
            'price'         => 950,
            'bitrix_id'     => 1352
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Ромашка одноголовая',
            'cost'          => 35,
            'price'         => 70,
            'bitrix_id'     => 1359
        ),
        array(
            'category_name' => 'Шары',
            'title'         => '"Шар фольгированный 36"" «Мишка», цвет розовый"',
            'cost'          => 139,
            'price'         => 690,
            'bitrix_id'     => 1366
        ),
        array(
            'category_name' => 'Подарки',
            'title'         => 'Фонтан фольга круг 5 шт',
            'cost'          => 80,
            'price'         => 1200,
            'bitrix_id'     => 1378
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза синяя 60 см (Эквадор)',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 1379
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка Сердце M (H 7см; D 17,5см)',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 1387
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка Сердце S (H 5,5см; D 15см)',
            'cost'          => 100,
            'price'         => 200,
            'bitrix_id'     => 1388
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка Сердце L (H 8,5см; D 20см)',
            'cost'          => 200,
            'price'         => 500,
            'bitrix_id'     => 1389
        ),
        array(
            'category_name' => 'Подарки',
            'title'         => 'Мыло ручной работы- порция',
            'cost'          => 25,
            'price'         => 80,
            'bitrix_id'     => 1396
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Конфеты Raffaello с цельным миндальным 100 г',
            'cost'          => 309,
            'price'         => 620,
            'bitrix_id'     => 1422
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Конфеты Ferrero Rocher 125гр',
            'cost'          => 345,
            'price'         => 690,
            'bitrix_id'     => 1423
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => '"Шоколад ""мерси"" в ассортименте 100гр"',
            'cost'          => 167,
            'price'         => 350,
            'bitrix_id'     => 1425
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Мерси 400г 1х8шт Ассорти',
            'cost'          => 526,
            'price'         => 1052,
            'bitrix_id'     => 1427
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Астильба',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 1435
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гладиолус',
            'cost'          => 125,
            'price'         => 250,
            'bitrix_id'     => 1452
        ),
        array(
            'category_name' => 'Подарки',
            'title'         => 'Растущий сувенир',
            'cost'          => 59,
            'price'         => 290,
            'bitrix_id'     => 1460
        ),
        array(
            'category_name' => 'Открытки',
            'title'         => 'Открытка двойная',
            'cost'          => 41,
            'price'         => 150,
            'bitrix_id'     => 1472
        ),
        array(
            'category_name' => 'Открытки',
            'title'         => 'Открытка набор простой',
            'cost'          => 45,
            'price'         => 250,
            'bitrix_id'     => 1473
        ),
        array(
            'category_name' => 'Открытки',
            'title'         => 'Открытка набор сложный',
            'cost'          => 77,
            'price'         => 300,
            'bitrix_id'     => 1474
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'Raffaello с миндалем 240 (книга) г',
            'cost'          => 487,
            'price'         => 990,
            'bitrix_id'     => 1490
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Шоколад 27гр',
            'cost'          => 70,
            'price'         => 220,
            'bitrix_id'     => 1501
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Буква шоколадная',
            'cost'          => 25,
            'price'         => 60,
            'bitrix_id'     => 1516
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Корзина плетеная прямоугольная 19 см × 14,5 см ×37 см',
            'cost'          => 100,
            'price'         => 200,
            'bitrix_id'     => 1521
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Корзина плетеная цилиндр XS (13 см × 13 см × 28 см)',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 1522
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Корзина плет',
            'cost'          => 125,
            'price'         => 550,
            'bitrix_id'     => 1523
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Мыльная роза (бутон)',
            'cost'          => 10,
            'price'         => 85,
            'bitrix_id'     => 1527
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Зимний декор',
            'cost'          => 33,
            'price'         => 75,
            'bitrix_id'     => 1534
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Гендерный шар',
            'cost'          => 300,
            'price'         => 1500,
            'bitrix_id'     => 1539
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Фонтан Моей милой 6 шаров',
            'cost'          => 153,
            'price'         => 1500,
            'bitrix_id'     => 1540
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Леденец',
            'cost'          => 75,
            'price'         => 190,
            'bitrix_id'     => 1544
        ),
        array(
            'category_name' => 'Сувениры',
            'title'         => 'Набор для ванны Слезы моих бывших',
            'cost'          => 245,
            'price'         => 490,
            'bitrix_id'     => 1555
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза радужная Эквадор (60 см)',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 1572
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Монеты шоколадные «Лучшему из лучших»: 5 шт. х 6 г',
            'cost'          => 79,
            'price'         => 158,
            'bitrix_id'     => 1580
        ),
        array(
            'category_name' => 'Сувениры',
            'title'         => 'Набор гель для душа-виски, мыло-сигара',
            'cost'          => 220,
            'price'         => 440,
            'bitrix_id'     => 1582
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'Шоколад 5г',
            'cost'          => 42,
            'price'         => 90,
            'bitrix_id'     => 1585
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Корица связка 3 шт',
            'cost'          => 50,
            'price'         => 250,
            'bitrix_id'     => 1599
        ),
        array(
            'category_name' => 'Сувениры',
            'title'         => 'Птичка на прищепке',
            'cost'          => 50,
            'price'         => 200,
            'bitrix_id'     => 1600
        ),
        array(
            'category_name' => 'Сувениры',
            'title'         => 'Шишка',
            'cost'          => 40,
            'price'         => 120,
            'bitrix_id'     => 1602
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => '"Корзинка ""Штаны Санты"""',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 1609
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Елка искусственная 120 см',
            'cost'          => 1750,
            'price'         => 5500,
            'bitrix_id'     => 1614
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Елка искусственная 150 см',
            'cost'          => 2730,
            'price'         => 8500,
            'bitrix_id'     => 1615
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Елка искусственная 180 см',
            'cost'          => 4550,
            'price'         => 12500,
            'bitrix_id'     => 1616
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Елка искусственная 210 см',
            'cost'          => 6800,
            'price'         => 15500,
            'bitrix_id'     => 1617
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Набор елочных шаров 34шт, 4см',
            'cost'          => 770,
            'price'         => 1540,
            'bitrix_id'     => 1618
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Набор елочных шаров 18шт, с верхушкой',
            'cost'          => 595,
            'price'         => 1190,
            'bitrix_id'     => 1619
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Набор елочных шаров 24шт, 4см',
            'cost'          => 455,
            'price'         => 910,
            'bitrix_id'     => 1620
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Набор елочных шаров 24шт, 6см',
            'cost'          => 395,
            'price'         => 1300,
            'bitrix_id'     => 1621
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Набор елочных шаров 30шт, 3 см с верхушкой',
            'cost'          => 455,
            'price'         => 910,
            'bitrix_id'     => 1622
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Конфеты Raffaello с цельным миндальным орехом 200 г',
            'cost'          => 550,
            'price'         => 1100,
            'bitrix_id'     => 1630
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза теплица одн. 30 см Микс',
            'cost'          => 32,
            'price'         => 64,
            'bitrix_id'     => 1632
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => '"Стаканчик для цветов ""Только для тебя"" 13*16"',
            'cost'          => 39,
            'price'         => 300,
            'bitrix_id'     => 1648
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Деревянный ящик конверт',
            'cost'          => 240,
            'price'         => 480,
            'bitrix_id'     => 1651
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Яблочко декоративное',
            'cost'          => 7,
            'price'         => 20,
            'bitrix_id'     => 1652
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Цветок Пуансеттия (Рождественник)',
            'cost'          => 130,
            'price'         => 260,
            'bitrix_id'     => 1663
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Крафт дизайнерский',
            'cost'          => 18,
            'price'         => 100,
            'bitrix_id'     => 1669
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Конус для цветов сердце 60х15',
            'cost'          => 10,
            'price'         => 50,
            'bitrix_id'     => 1670
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Шар обруч мики',
            'cost'          => 25,
            'price'         => 190,
            'bitrix_id'     => 1677
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Набор шаров Королева 6 шт',
            'cost'          => 170,
            'price'         => 1500,
            'bitrix_id'     => 1679
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Мускари',
            'cost'          => 28,
            'price'         => 56,
            'bitrix_id'     => 1687
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Флум сухоцвет (пучок 15шт)',
            'cost'          => 75,
            'price'         => 150,
            'bitrix_id'     => 1692
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Папоротник',
            'cost'          => 35,
            'price'         => 70,
            'bitrix_id'     => 1697
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Камыш',
            'cost'          => 3,
            'price'         => 25,
            'bitrix_id'     => 1699
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Мишка мини плюшевый 16 см сидя',
            'cost'          => 160,
            'price'         => 650,
            'bitrix_id'     => 1722
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'Шоколад 70 гр',
            'cost'          => 130,
            'price'         => 260,
            'bitrix_id'     => 1725
        ),
        array(
            'category_name' => 'Сувениры',
            'title'         => 'Валентинка',
            'cost'          => 6,
            'price'         => 50,
            'bitrix_id'     => 1727
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гениста',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 1739
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Трахелиум',
            'cost'          => 125,
            'price'         => 250,
            'bitrix_id'     => 1742
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лотос сухоцвет',
            'cost'          => 55,
            'price'         => 110,
            'bitrix_id'     => 1774
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза тепличная (90 см)',
            'cost'          => 99,
            'price'         => 198,
            'bitrix_id'     => 1801
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Каллы',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 1811
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Маттиола',
            'cost'          => 125,
            'price'         => 250,
            'bitrix_id'     => 1815
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Пион',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 1816
        ),
        array(
            'category_name' => 'Подарки',
            'title'         => 'Котенок в костюме (15 см)',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 1836
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гипсофила Радужная 60 см',
            'cost'          => 114,
            'price'         => 228,
            'bitrix_id'     => 1844
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза подмосковная (50 см)',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 1857
        ),
        array(
            'category_name' => 'Сувениры',
            'title'         => 'Свеча в банке 180гр',
            'cost'          => 300,
            'price'         => 600,
            'bitrix_id'     => 1890
        ),
        array(
            'category_name' => 'Сувениры',
            'title'         => 'Свеча в банке 315гр',
            'cost'          => 117,
            'price'         => 390,
            'bitrix_id'     => 1893
        ),
        array(
            'category_name' => 'Сувениры',
            'title'         => 'Свеча ассорти 160',
            'cost'          => 160,
            'price'         => 450,
            'bitrix_id'     => 1898
        ),
        array(
            'category_name' => 'Подарки',
            'title'         => '"Кашпо керамическое ""Котенок"" 8*8*8см"',
            'cost'          => 253,
            'price'         => 425,
            'bitrix_id'     => 1905
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка в форме сердца Sunshine',
            'cost'          => 175,
            'price'         => 500,
            'bitrix_id'     => 1907
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Ваза голова',
            'cost'          => 480,
            'price'         => 960,
            'bitrix_id'     => 1910
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хризантема Момоко (одноголовая)',
            'cost'          => 140,
            'price'         => 280,
            'bitrix_id'     => 1914
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Эквадор Микс (70 см)',
            'cost'          => 130,
            'price'         => 260,
            'bitrix_id'     => 1922
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гвоздика Диантус Люкс',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 1923
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Озатамнус (зелень)',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 1924
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Озатамнус (сухоцвет)',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 1925
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хризантема Бигоуди Ред (одноголовая)',
            'cost'          => 157,
            'price'         => 314,
            'bitrix_id'     => 1928
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Бумага Эко жат',
            'cost'          => 38,
            'price'         => 150,
            'bitrix_id'     => 1930
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Пампас (камыш)',
            'cost'          => 25,
            'price'         => 100,
            'bitrix_id'     => 1933
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Стиф (пучок 0,3)',
            'cost'          => 110,
            'price'         => 220,
            'bitrix_id'     => 1934
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гортензия стабилизированная',
            'cost'          => 600,
            'price'         => 1200,
            'bitrix_id'     => 1935
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Эвкалипт стабилизированный',
            'cost'          => 70,
            'price'         => 140,
            'bitrix_id'     => 1936
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Хризантема Сантини мини Люкс',
            'cost'          => 73,
            'price'         => 146,
            'bitrix_id'     => 1946
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Нигелла 0,5 (Сухоцвет)',
            'cost'          => 100,
            'price'         => 200,
            'bitrix_id'     => 1947
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Оксипеталум',
            'cost'          => 125,
            'price'         => 250,
            'bitrix_id'     => 1948
        ),
        array(
            'category_name' => 'Товар LUX',
            'title'         => 'Пампасная трава Lux',
            'cost'          => 250,
            'price'         => 500,
            'bitrix_id'     => 2000
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Ваза Юта (30 см)',
            'cost'          => 450,
            'price'         => 900,
            'bitrix_id'     => 2001
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Ваза Рим (26 см)',
            'cost'          => 550,
            'price'         => 1100,
            'bitrix_id'     => 2002
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Ваза скала (29 см)',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 2003
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Ваза Евро (22 см)',
            'cost'          => 250,
            'price'         => 500,
            'bitrix_id'     => 2004
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Ваза Лиза (32см)',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 2005
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Ваза Шарик (11 см)',
            'cost'          => 250,
            'price'         => 500,
            'bitrix_id'     => 2006
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Ваза жемчужина (30 см)',
            'cost'          => 550,
            'price'         => 1100,
            'bitrix_id'     => 2007
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Ваза Волна (38 см)',
            'cost'          => 550,
            'price'         => 1100,
            'bitrix_id'     => 2008
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Ваза Жаклин (31 см)',
            'cost'          => 350,
            'price'         => 800,
            'bitrix_id'     => 2009
        ),
        array(
            'category_name' => 'Склад LUX',
            'title'         => 'Ваза Ананас (24 см)',
            'cost'          => 450,
            'price'         => 900,
            'bitrix_id'     => 2010
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Кенингстоун Пионовидная одноголовая',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 2013
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лейко',
            'cost'          => 100,
            'price'         => 200,
            'bitrix_id'     => 2014
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Сафари',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 2015
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Кения Микс одноголовая пионовидная 40 см',
            'cost'          => 39,
            'price'         => 78,
            'bitrix_id'     => 2018
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Коробка шляпная S ( lux Бархат)',
            'cost'          => 550,
            'price'         => 1100,
            'bitrix_id'     => 2041
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Ротанговый шар 3 см',
            'cost'          => 11,
            'price'         => 50,
            'bitrix_id'     => 2043
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Ротанговый шар 5 см',
            'cost'          => 21,
            'price'         => 100,
            'bitrix_id'     => 2044
        ),
        array(
            'category_name' => 'Оформление LUX',
            'title'         => 'Лента Lux атлас',
            'cost'          => 15,
            'price'         => 100,
            'bitrix_id'     => 2045
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Коробка транспортировочная для цветов 53 см',
            'cost'          => 125,
            'price'         => 550,
            'bitrix_id'     => 2056
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гиацинт',
            'cost'          => 85,
            'price'         => 170,
            'bitrix_id'     => 2099
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Кения одн. 40 см (А2)',
            'cost'          => 27,
            'price'         => 54,
            'bitrix_id'     => 2106
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Астранция',
            'cost'          => 80,
            'price'         => 160,
            'bitrix_id'     => 2124
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Клематис Star River',
            'cost'          => 95,
            'price'         => 190,
            'bitrix_id'     => 2125
        ),
        array(
            'category_name' => 'Подарки',
            'title'         => 'Холст синтетический 60х40 см',
            'cost'          => 1700,
            'price'         => 3400,
            'bitrix_id'     => 2126
        ),
        array(
            'category_name' => 'Вазы',
            'title'         => 'Аквабокс',
            'cost'          => 100,
            'price'         => 200,
            'bitrix_id'     => 2164
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'клубника',
            'cost'          => 45,
            'price'         => 130,
            'bitrix_id'     => 2183
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'клубника в шоколаде',
            'cost'          => 60,
            'price'         => 160,
            'bitrix_id'     => 2184
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'клубника в присыпке',
            'cost'          => 80,
            'price'         => 180,
            'bitrix_id'     => 2185
        ),
        array(
            'category_name' => 'Упаковка',
            'title'         => 'Каркас',
            'cost'          => 25,
            'price'         => 100,
            'bitrix_id'     => 2190
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза белая (50 см) ПД',
            'cost'          => 65,
            'price'         => 130,
            'bitrix_id'     => 2217
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Цыпа мини брелок микс (13 см)',
            'cost'          => 200,
            'price'         => 400,
            'bitrix_id'     => 2226
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Зайка мини брелок',
            'cost'          => 140,
            'price'         => 450,
            'bitrix_id'     => 2227
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Утка (70 см)',
            'cost'          => 550,
            'price'         => 1100,
            'bitrix_id'     => 2228
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Илекс',
            'cost'          => 170,
            'price'         => 340,
            'bitrix_id'     => 2568
        ),
        array(
            'category_name' => 'Шары',
            'title'         => 'Гелий (400 ед)',
            'cost'          => 32,
            'price'         => 100,
            'bitrix_id'     => 2745
        ),
        array(
            'category_name' => '',
            'title'         => 'Букет орхидей М',
            'cost'          => 10,
            'price'         => 50,
            'bitrix_id'     => 2755
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Георгина',
            'cost'          => 110,
            'price'         => 220,
            'bitrix_id'     => 2808
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Сумочка картон',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 2949
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лист дуба крашенный',
            'cost'          => 79,
            'price'         => 158,
            'bitrix_id'     => 2954
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Сетария сухоцвет',
            'cost'          => 26,
            'price'         => 100,
            'bitrix_id'     => 2956
        ),
        array(
            'category_name' => 'Новый Год',
            'title'         => 'Гирлянда',
            'cost'          => 50,
            'price'         => 300,
            'bitrix_id'     => 2977
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Оазис',
            'cost'          => 90,
            'price'         => 180,
            'bitrix_id'     => 2980
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Анемон Мистраль Плюс пинк',
            'cost'          => 90,
            'price'         => 180,
            'bitrix_id'     => 9080
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гербера мини',
            'cost'          => 88,
            'price'         => 146,
            'bitrix_id'     => 9081
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Ирис Белый',
            'cost'          => 63,
            'price'         => 126,
            'bitrix_id'     => 9082
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Амариллис',
            'cost'          => 250,
            'price'         => 500,
            'bitrix_id'     => 9087
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Кустовая 30 см (Микс)',
            'cost'          => 80,
            'price'         => 160,
            'bitrix_id'     => 9090
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Кустовая 40 см (Микс)',
            'cost'          => 100,
            'price'         => 200,
            'bitrix_id'     => 9091
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Гиацинт в горшке',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 9100
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза кустовая пионовидная (60 см)',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 9135
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза кустовая пионовидная (70 см)',
            'cost'          => 200,
            'price'         => 400,
            'bitrix_id'     => 9136
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза кустовая пионовидная (90 см)',
            'cost'          => 210,
            'price'         => 420,
            'bitrix_id'     => 9137
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Пионы Рейне Хортенс',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 9152
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Верба',
            'cost'          => 40,
            'price'         => 80,
            'bitrix_id'     => 9162
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Сирень',
            'cost'          => 285,
            'price'         => 570,
            'bitrix_id'     => 9168
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Аллиум',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 9170
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Маттиола кустовая',
            'cost'          => 159,
            'price'         => 318,
            'bitrix_id'     => 9171
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Дельфиниум',
            'cost'          => 175,
            'price'         => 350,
            'bitrix_id'     => 9186
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Вибирнум',
            'cost'          => 225,
            'price'         => 450,
            'bitrix_id'     => 9191
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Трохелиум',
            'cost'          => 125,
            'price'         => 250,
            'bitrix_id'     => 9192
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Крокосмиа',
            'cost'          => 85,
            'price'         => 170,
            'bitrix_id'     => 9193
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Амарантус',
            'cost'          => 149,
            'price'         => 298,
            'bitrix_id'     => 9194
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Флокс',
            'cost'          => 88,
            'price'         => 176,
            'bitrix_id'     => 9195
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Картамусс',
            'cost'          => 88,
            'price'         => 176,
            'bitrix_id'     => 9196
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Архилея',
            'cost'          => 82,
            'price'         => 164,
            'bitrix_id'     => 9197
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Солидаго',
            'cost'          => 88,
            'price'         => 176,
            'bitrix_id'     => 9198
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Серрурия',
            'cost'          => 83,
            'price'         => 166,
            'bitrix_id'     => 9199
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Артишок',
            'cost'          => 242,
            'price'         => 484,
            'bitrix_id'     => 9200
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Астер кассандра',
            'cost'          => 111,
            'price'         => 222,
            'bitrix_id'     => 9201
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Антериум',
            'cost'          => 135,
            'price'         => 270,
            'bitrix_id'     => 9202
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Леукоспермум',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 9203
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Антигозантус',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 9204
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Буварди',
            'cost'          => 120,
            'price'         => 240,
            'bitrix_id'     => 9205
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Книфофия',
            'cost'          => 53,
            'price'         => 106,
            'bitrix_id'     => 9206
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Берцелия',
            'cost'          => 68,
            'price'         => 136,
            'bitrix_id'     => 9207
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Банксия',
            'cost'          => 250,
            'price'         => 500,
            'bitrix_id'     => 9208
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Мята',
            'cost'          => 48,
            'price'         => 96,
            'bitrix_id'     => 9209
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Ариганум',
            'cost'          => 1,
            'price'         => 2,
            'bitrix_id'     => 9210
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Амми Касабланка',
            'cost'          => 56,
            'price'         => 112,
            'bitrix_id'     => 9211
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Физостигия',
            'cost'          => 59,
            'price'         => 118,
            'bitrix_id'     => 9212
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Гринбелл',
            'cost'          => 80,
            'price'         => 160,
            'bitrix_id'     => 9222
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Буплерум',
            'cost'          => 95,
            'price'         => 190,
            'bitrix_id'     => 9255
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Амми Виснага',
            'cost'          => 56,
            'price'         => 112,
            'bitrix_id'     => 9256
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Эремурус',
            'cost'          => 221,
            'price'         => 442,
            'bitrix_id'     => 9257
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Молюцелла',
            'cost'          => 135,
            'price'         => 270,
            'bitrix_id'     => 9258
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Каллизия',
            'cost'          => 77,
            'price'         => 154,
            'bitrix_id'     => 9259
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Сандерсония',
            'cost'          => 209,
            'price'         => 418,
            'bitrix_id'     => 9260
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Латирус душистый',
            'cost'          => 74,
            'price'         => 148,
            'bitrix_id'     => 9261
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза кустовая (80 см)',
            'cost'          => 200,
            'price'         => 400,
            'bitrix_id'     => 9269
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Ванда',
            'cost'          => 140,
            'price'         => 280,
            'bitrix_id'     => 9274
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Бруния',
            'cost'          => 80,
            'price'         => 160,
            'bitrix_id'     => 9275
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза эквадор 50 см',
            'cost'          => 90,
            'price'         => 180,
            'bitrix_id'     => 9281
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Аспарагус',
            'cost'          => 90,
            'price'         => 180,
            'bitrix_id'     => 9283
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза радужная Эквадор (70 см)',
            'cost'          => 130,
            'price'         => 260,
            'bitrix_id'     => 9338
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Нерине',
            'cost'          => 125,
            'price'         => 250,
            'bitrix_id'     => 9340
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Илекс искуственный',
            'cost'          => 125,
            'price'         => 250,
            'bitrix_id'     => 9356
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Лагурус',
            'cost'          => 50,
            'price'         => 100,
            'bitrix_id'     => 9357
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Декор мини ягодки',
            'cost'          => 10,
            'price'         => 30,
            'bitrix_id'     => 9359
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Ветка декоративная',
            'cost'          => 30,
            'price'         => 150,
            'bitrix_id'     => 9362
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Плюшевый пудель 25 см',
            'cost'          => 350,
            'price'         => 1000,
            'bitrix_id'     => 9371
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Мишка 20 см',
            'cost'          => 350,
            'price'         => 1000,
            'bitrix_id'     => 9372
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Новогодняя мышка 12 см',
            'cost'          => 150,
            'price'         => 400,
            'bitrix_id'     => 9373
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Мышка 8 см',
            'cost'          => 100,
            'price'         => 250,
            'bitrix_id'     => 9374
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Мишка Тедди 30 см',
            'cost'          => 350,
            'price'         => 1000,
            'bitrix_id'     => 9375
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Мишка Нежность 30 см',
            'cost'          => 350,
            'price'         => 1200,
            'bitrix_id'     => 9376
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Мишка Лав 20 см',
            'cost'          => 300,
            'price'         => 900,
            'bitrix_id'     => 9377
        ),
        array(
            'category_name' => 'Мягкие игрушки',
            'title'         => 'Плюшевый медведь (80 см)',
            'cost'          => 1300,
            'price'         => 4600,
            'bitrix_id'     => 9379
        ),
        array(
            'category_name' => 'Сувениры',
            'title'         => 'Свеча подарочная',
            'cost'          => 400,
            'price'         => 1350,
            'bitrix_id'     => 9397
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Эльф',
            'cost'          => 1000,
            'price'         => 3500,
            'bitrix_id'     => 9410
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Шишка большая',
            'cost'          => 40,
            'price'         => 200,
            'bitrix_id'     => 9411
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Звезда декор',
            'cost'          => 150,
            'price'         => 400,
            'bitrix_id'     => 9413
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Апельсин декор (связка 3 шт)',
            'cost'          => 45,
            'price'         => 150,
            'bitrix_id'     => 9414
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Фигурка новогодняя',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 9418
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Волос ангела декор',
            'cost'          => 70,
            'price'         => 140,
            'bitrix_id'     => 9419
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Конифер',
            'cost'          => 143,
            'price'         => 286,
            'bitrix_id'     => 9422
        ),
        array(
            'category_name' => 'Открытки',
            'title'         => 'Открытка набор Новогодний',
            'cost'          => 100,
            'price'         => 355,
            'bitrix_id'     => 9450
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Пакет подарочный XS',
            'cost'          => 28,
            'price'         => 120,
            'bitrix_id'     => 9460
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Пакет подарочный S',
            'cost'          => 32,
            'price'         => 150,
            'bitrix_id'     => 9461
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Пакет подарочный M',
            'cost'          => 45,
            'price'         => 200,
            'bitrix_id'     => 9462
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Пакет подарочный L',
            'cost'          => 57,
            'price'         => 250,
            'bitrix_id'     => 9463
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Пакет бутылочный',
            'cost'          => 41,
            'price'         => 180,
            'bitrix_id'     => 9464
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Скабиоза',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 9492
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Корзина плетенная M',
            'cost'          => 400,
            'price'         => 800,
            'bitrix_id'     => 9500
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Стрелиция',
            'cost'          => 250,
            'price'         => 500,
            'bitrix_id'     => 9504
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Корзинка с ручкой',
            'cost'          => 200,
            'price'         => 450,
            'bitrix_id'     => 9508
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Шляпная коробка 2XL',
            'cost'          => 600,
            'price'         => 1500,
            'bitrix_id'     => 9515
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Пион Дюшес белый',
            'cost'          => 350,
            'price'         => 700,
            'bitrix_id'     => 9519
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза синяя Эквадор (70 см)',
            'cost'          => 130,
            'price'         => 260,
            'bitrix_id'     => 9522
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Джульетта кустовая',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 9523
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза Эквадор (80 см)',
            'cost'          => 150,
            'price'         => 300,
            'bitrix_id'     => 9524
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза кустовая 60 см',
            'cost'          => 180,
            'price'         => 360,
            'bitrix_id'     => 9536
        ),
        array(
            'category_name' => 'Продукция',
            'title'         => 'Корзина S',
            'cost'          => 400,
            'price'         => 810,
            'bitrix_id'     => 9542
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Тюльпан пионовидный голландия',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 9561
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Тюльпан (местный)',
            'cost'          => 60,
            'price'         => 120,
            'bitrix_id'     => 9575
        ),
        array(
            'category_name' => 'Сладости',
            'title'         => 'Дражже',
            'cost'          => 72,
            'price'         => 165,
            'bitrix_id'     => 9586
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'Шоколадные конфеты Ferrero 200гр',
            'cost'          => 609,
            'price'         => 1250,
            'bitrix_id'     => 9608
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'Шоколадные Merci 250г',
            'cost'          => 325,
            'price'         => 700,
            'bitrix_id'     => 9610
        ),
        array(
            'category_name' => 'Конфеты и сладости',
            'title'         => 'Шоколад 100г',
            'cost'          => 50,
            'price'         => 350,
            'bitrix_id'     => 9647
        ),
        array(
            'category_name' => 'Коробки и корзинки',
            'title'         => 'Корзина S плетенная',
            'cost'          => 200,
            'price'         => 600,
            'bitrix_id'     => 9677
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Анемон микс',
            'cost'          => 100,
            'price'         => 200,
            'bitrix_id'     => 9684
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Роза люкс Дениз',
            'cost'          => 160,
            'price'         => 320,
            'bitrix_id'     => 9795
        ),
        array(
            'category_name' => 'Цветы',
            'title'         => 'Кустовая роза Голландия 50 см',
            'cost'          => 90,
            'price'         => 180,
            'bitrix_id'     => 9800
        )
    );

    exit();
    foreach ($items as $item) {
        $Composition = new Composition($main_table);
        $Res[] = $Composition->save($item);
    }
}
