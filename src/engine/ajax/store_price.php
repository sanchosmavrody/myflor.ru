<?php

$Res = [];
$fieldSetting = ['title', 'show_table', 'show_form', 'form_type',];
$tableName = $_REQUEST['mod'];
$mod = $_REQUEST['mod'];


if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if ($id == 0 and $_POST['submit'] == 'add') {

        $columns = getColumns($tableName);

        $arr = [];
        foreach ($columns as $field) {
            if ($field['column_name'] !== 'id' and $field['form_type'] != 'img' and isset($_POST[$field['column_name']])) {
                $arr['fields'][] = "{$field['column_name']}";
                $arr['values'][] = "'{$_POST[$field['column_name']]}'";
            }
            if ($field['form_type'] == 'img') {
                $uploadedUmg = uploadImg($id, $mod, $field['column_name']);//загружаем новые если прислали
                $allimg = [];
                foreach ($_POST[$field['column_name']] as $nowImg)
                    $allimg[] = $nowImg;
                if ($uploadedUmg !== false)
                    foreach ($uploadedUmg as $nowImg)
                        $allimg[] = $nowImg;

                $allimg = implode(',', $allimg);

                $arr['fields'][] = "{$field['column_name']}";
                $arr['values'][] = "'{$allimg}'";
            }
        }
        $values = implode(', ', $arr['values']);
        $fields = implode(', ', $arr['fields']);
        $db->query("INSERT INTO {$tableName} ({$fields}) VALUES ({$values}) ;");


        header("Location: /?mod=" . $mod);
        die();
    }
    if ($id > 0 and $_POST['submit'] == 'edit') {
        $columns = getColumns($tableName);
        $strWhere = " id = '{$id}'";
        $arr = [];
        foreach ($columns as $field) {
            if ($field['column_name'] !== 'id' and $field['form_type'] != 'img' and isset($_POST[$field['column_name']]))
                $arr[] = " {$field['column_name']} = '{$_POST[$field['column_name']]}' ";


            if ($field['form_type'] == 'img') {
                $uploadedUmg = uploadImg($id, $mod, $field['column_name']);//загружаем новые если прислали

                $allimg = [];
                foreach ($_POST[$field['column_name']] as $nowImg)
                    if ($nowImg)
                        $allimg[] = $nowImg;
                if ($uploadedUmg !== false)
                    foreach ($uploadedUmg as $nowImg)
                        $allimg[] = $nowImg;

                $allimg = implode(',', $allimg);
                $arr[] = " {$field['column_name']} = '{$allimg}' ";
            }

        }
        $argsStr = implode(", ", $arr);
        $sql = <<<SQL
UPDATE {$tableName} SET {$argsStr} WHERE {$strWhere} ;
SQL;

        $db->query($sql);
        header("Location: /?mod=" . $mod);
        die();
    }
}

if ($_REQUEST['act'] == 'data') {

    if (isset($_REQUEST['search']['value'])) $searchValue = trim($_REQUEST['search']['value']);

    $ORDER = '';
    $WHERE = " WHERE 1 = 1 ";
    $LIMIT = 100;

    if (isset($_REQUEST['serverside']) and $_REQUEST['serverside'] == 1) {
        if (isset($_REQUEST['order'][0]) and $_REQUEST['columns'][$_REQUEST['order'][0]['column']]['data'])
            $ORDER = " ORDER BY {$_REQUEST['columns'][$_REQUEST['order'][0]['column']]['data']} {$_REQUEST['order'][0]['dir']} ";

        if ((isset($searchValue) and strlen($searchValue) > 3) or isset($_REQUEST['filter'])) {

            $filtersToSearch = [
                'code'       => " LIKE '%{$searchValue}%'",
                'name'       => " LIKE '%{$searchValue}%'",
                'price'      => "='{$searchValue}'",
                'store'      => " LIKE '%{$searchValue}%'",
                'subsection' => " LIKE '%{$searchValue}%'",
            ];

            $parts = [];
            foreach ($filtersToSearch as $field => $sqlStr) {
                if (isset($searchValue) and strlen($searchValue) > 3)
                    $parts[] = "store_price.{$field} {$sqlStr}";
            }

            if (count($parts)) {
                $parts = implode(' OR ', $parts);
                $WHERE .= " AND ({$parts})";
            }
        }

        if (isset($_REQUEST['length']) and isset($_REQUEST['start']))
            $LIMIT = "{$_REQUEST['start']},{$_REQUEST['length']}";
    }

    $sql_FROM = "FROM store_price
    LEFT JOIN store_basket ON store_price.id = store_basket.price_id and store_basket.order_id = 0 and user_id = '{$nowUser['id']}'
    ";

    $total_count = $db->super_query("SELECT COUNT(store_price.id) as total_count " . $sql_FROM);
    $total_count = $total_count['total_count'];

    $filtered_count = $db->super_query("SELECT COUNT(store_price.id) as filtered_count " . $sql_FROM . $WHERE);
    $filtered_count = $filtered_count['filtered_count'];

    $rows = $db->super_query("SELECT store_price.*, IFNULL(store_basket.amount, 0) as amountBasket " . $sql_FROM . $WHERE . $ORDER . " LIMIT {$LIMIT}", true);

    foreach ($rows as &$row) {
        $row['price'] = (int)$row['price'] - round((int)$row['price'] / 100 * $nowUser['price_discount']);
        if ($row['amountBasket'])
            $row['basket'] = <<<HTML
<div class="input-group input-group-sm basketControl inBasket">
    <input min="1" data-nomenclature_id="{$row['nomenclatureId']}" data-price="{$row['price']}" data-id="{$row['id']}" type="number" class="form-control" value="{$row['amountBasket']}" >
    <button data-nomenclature_id="{$row['nomenclatureId']}" data-price="{$row['price']}" data-id="{$row['id']}" class="btn btn-outline-danger btn-xs" type="button">
        <i class='fas fa-shopping-basket'></i>
    </button>
</div>
HTML;
        else
            $row['basket'] = <<<HTML
<div class="input-group input-group-sm basketControl">
    <input  min="1" data-nomenclature_id="{$row['nomenclatureId']}" data-price="{$row['price']}" data-id="{$row['id']}" type="number" class="form-control" value="1" >
    <button data-nomenclature_id="{$row['nomenclatureId']}" data-price="{$row['price']}" data-id="{$row['id']}" class="btn btn-outline-default btn-xs" type="button">
        <i class='fas fa-shopping-basket'></i>
    </button>
</div>
HTML;
    }

    if (isset($_REQUEST['serverside']) and $_REQUEST['serverside'] == 1)
        $Res = ['data'            => $rows, "draw" => $_REQUEST['draw']++,
                "recordsTotal"    => $total_count,
                "recordsFiltered" => $filtered_count];
    else
        $Res = ['data' => $rows];
}

if ($_REQUEST['act'] == 'columnsTable') {

    $columns = getColumns($tableName);

    // Такой маппинг просит DataTable
    $columns_ = [
        [
            "data"           => null,
            "title"          => '',
            "defaultContent" =>
                "<button class='btn btn-outline-secondary btn-xs btnEdit' data-toggle='modal' data-target='#modal_form_edit'  > <i class='fas fa-edit'></i> </button>"
        ],
        [
            "data" => 'id', "title" => 'id',
        ],
    ];

    foreach ($columns as $col) {
        if ($col['show_table'] == 1) {
            $columns_[] = [
                "data" => $col['column_name'], "title" => $col['title']
            ];
        }
    }

    $columns_[] =
        [
            "data"  => 'basket',
            "title" => "<i class='fas fa-shopping-basket'></i>",
        ];

    $Res = $columns_;
}

if ($_REQUEST['act'] == 'formTable') {

    $columns = getColumns($tableName);

    if ($_REQUEST['type'] == 'edit') {

        $id = $_REQUEST['id'];
        $thisItem = $db->super_query("SELECT * FROM {$tableName} WHERE id = '{$id}'; ");

        $sql = <<<SQL
SELECT store_price.*,
(SELECT GROUP_CONCAT(CONCAT(id,'|',name,'|',sort)) as images FROM `store_images` WHERE module = 'store_price' AND `object_id` = store_price.id AND type = 'THUMB' ORDER BY `sort`) as images
FROM store_price
WHERE id='{$thisItem['id']}';
SQL;
        $thisItemDetails = $db->super_query($sql);

        $images = explode(',', $thisItemDetails['images']);
        $sortedImages = [];
        foreach ($images as $item) {
            $item_ = explode('|', $item);
            $sortedImages[$item_[2] . $item_[0]] = $item;
        }
        ksort($sortedImages);

        $thisItem['img'] = implode(',', $sortedImages);
    }

    $columns[] = [
        'column_name' => 'img',
        'form_type'   => 'img',
        'show_form'   => 1,
        'title'       => 'Фото'
    ];

    foreach ($columns as &$col) {
        if ($col['show_form'] > 0) {
            $col['val'] = isset($thisItem[$col['column_name']]) ? $thisItem[$col['column_name']] : false;
        }
    }

    $Res['columns'] = $columns;
}

if ($_REQUEST['act'] == 'getStats') {

    $sql = <<<SQL
SELECT COUNT(DISTINCT price_id) as count_position, SUM(price*amount) as total
FROM store_basket
WHERE store_basket.order_id = 0 and user_id = '{$nowUser['id']}'
SQL;
    $total_basket = $db->super_query($sql);


    $where_user = '';
    if ((!empty($nowUser['access']['store_orders']) and !in_array('Все заказы', $nowUser['access']['store_orders'])) and $nowUser['role_id'] != 1)
        $where_user = " and user_id = '{$nowUser['id']}'  ";

    $sql = <<<SQL
SELECT COUNT(DISTINCT id) as count_position
FROM store_orders
WHERE store_orders.status_id NOT IN ('5','6') {$where_user}
SQL;
    $total_order = $db->super_query($sql);


    $Res = [
        ['label' => "Заказы <span class='badge badge-danger'>{$total_order['count_position']}</span>",
         'url'   => '/crm.php?mod=store_orders'],
        ['label' => "Корзина <span class='badge badge-danger'>{$total_basket['count_position']}</span> на {$total_basket['total']}р.",
         'url'   => '/crm.php?mod=store_basket'],

    ];

}

