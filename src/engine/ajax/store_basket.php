<?php


$Res = [];
$fieldSetting = ['title', 'show_table', 'show_form', 'form_type',];
$tableName = 'store_basket';
$mod = 'store_basket';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    //$nomenclature_id = (int)$_GET['nomenclature_id'];
    $nomenclature_id = 0;

    if ($id > 0) {
        $result = $db->super_query("SELECT price FROM store_price WHERE id = '{$id}'");

        if (!empty($result)) {

            $price = $result['price'];

            $discount = isset($nowUser['price_discount']) ? (int)$nowUser['price_discount'] : 0;
            if ($discount > 0)
                $price = (int)$price - round((int)$price / 100 * $discount);


            if ($_GET['act'] == 'add') {

                $db->query("INSERT INTO store_basket (user_id, price_id, price, amount, nomenclature_id)
                    VALUES ('{$nowUser['id']}', '{$id}', '{$price}', '1', '{$nomenclature_id}');");
                $Res = [];
            } elseif ($_GET['act'] == 'remove') {
                $db->query("DELETE FROM store_basket WHERE price_id = '{$id}' AND user_id = '{$nowUser['id']}';");
                $Res = [];
            } elseif ($_GET['act'] == 'change') {
                $amount = (int)$_GET['amount'];
                if (!$amount) $amount = 1;
                $db->query("UPDATE store_basket SET amount = '{$amount}' WHERE price_id = '{$id}' AND user_id = '{$nowUser['id']}'; ");
                $Res = [];
            } elseif ($_GET['act'] == 'changePrice') {
                $price = (int)$_GET['price'];
                if ($price) {
                    $db->query("UPDATE store_basket SET price = '{$price}' WHERE price_id = '{$id}' AND user_id = '{$nowUser['id']}'; ");
                }
                $Res = [];
            }
        }

    }
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if ($id == 0 and $_POST['submit'] == 'add') {


        $Comment = $db->safesql($_POST['Comment']);
        $type = $db->safesql($_POST['type']);

        $id = $_REQUEST['id'];

        $basket_stats = $db->super_query("SELECT count(DISTINCT store_basket.price_id) as position_count, SUM(store_basket.price*store_basket.amount) as total
        FROM store_price JOIN store_basket ON store_price.id = store_basket.price_id and store_basket.order_id = 0 and user_id = '{$nowUser['id']}'");

        $client_id = 0;
        if (!empty($nowUser['client_id'])) {
            $client_id = $nowUser['client_id'];
        } else if (!empty($_POST['client_id']))
            $client_id = $_POST['client_id'];


        $db->query("INSERT INTO store_orders (user_id,client_id,type,Comment,total,date) VALUES ('{$nowUser['id']}','{$client_id}','{$type}','{$Comment}','{$basket_stats['total']}',NOW()) ;");

        $order_id = $db->insert_id();
        $db->query("UPDATE store_basket SET order_id = '{$order_id}' WHERE  user_id = '{$nowUser['id']}' and order_id = 0; ");

        header("Location: /crm.php?mod=store_orders");
        die();
    }
}

if ($_REQUEST['act'] == 'data') {

    if (isset($_REQUEST['search']['value'])) $searchValue = trim($_REQUEST['search']['value']);

    $ORDER = '';
    $WHERE = ' WHERE 1 = 1 AND store_price.price > 0 ';
    $LIMIT = 100;

    if (isset($_REQUEST['serverside']) and $_REQUEST['serverside'] == 1) {
        if (isset($_REQUEST['order'][0]) and $_REQUEST['columns'][$_REQUEST['order'][0]['column']]['data'])
            $ORDER = " ORDER BY {$_REQUEST['columns'][$_REQUEST['order'][0]['column']]['data']} {$_REQUEST['order'][0]['dir']} ";

        if ((isset($searchValue) and strlen($searchValue) > 3) or isset($_REQUEST['filter'])) {

            $filtersToSearch = [
                'id'          => "='{$searchValue}'",
                'description' => " LIKE '%{$searchValue}%'",
                'Comment'     => " LIKE '%{$searchValue}%'",
                'AMnumber'    => " LIKE '%{$searchValue}%'",
                'SALEbrand'   => "='{$searchValue}'",
                'SALEnumber'  => " LIKE '%{$searchValue}%'",
                'partType'    => "='{$searchValue}'",
                'store'       => "='{$searchValue}'",
            ];

            $parts = [];
            foreach ($filtersToSearch as $field => $sqlStr)
                if (isset($_REQUEST['filter']) and $_REQUEST['filter'][$field]) {
                    $_REQUEST['filter'][$field] = urldecode($_REQUEST['filter'][$field] == 'пусто' ? '' : $_REQUEST['filter'][$field]);
                    $WHERE .= " AND {$tableName}.{$field}='{$_REQUEST['filter'][$field]}'";
                } else if ((isset($searchValue) and strlen($searchValue) > 3))
                    $parts[] = "{$tableName}.{$field} {$sqlStr}";

            if ((isset($searchValue) and strlen($searchValue) > 3)) {
                $searchValue = str_replace([' ', '-', '.'], '', $searchValue);
                $parts[] = " {$tableName}.nomenclatureId 
            IN (SELECT DISTINCT catalog_fields.nomenclatureId 
            FROM catalog_fields JOIN catalog_structure ON catalog_structure.id = catalog_fields.structureId AND catalog_structure.search = 1 
            WHERE catalog_fields.search LIKE '%{$searchValue}%')";

            }

            if (isset($_REQUEST['filter']) and isset($_REQUEST['filter']['car'])) {

                $carFilterFields = ['carBrand', 'carModel', 'carV', 'carP', 'carP'];
                $whereCar = [];
                foreach ($carFilterFields as $carFilterField)
                    if (!empty($_REQUEST['filter']['car'][$carFilterField]))
                        $whereCar[] = "catalog_applicability.{$carFilterField} = '{$_REQUEST['filter']['car'][$carFilterField]}'";

                if (!empty($whereCar)) {
                    $whereCar = implode(' and ', $whereCar);
                    $parts[] = "{$tableName}.nomenclatureId 
            IN (SELECT catalog_fields.nomenclatureId
FROM catalog_fields
JOIN catalog_structure ON catalog_structure.id = catalog_fields.structureId AND catalog_structure.name = 'Применение'
JOIN catalog_applicability ON catalog_applicability.crossNumber	 = catalog_fields.value
WHERE {$whereCar})";
                }
            }

            if (count($parts)) {
                $parts = implode(' OR ', $parts);
                $WHERE .= " AND ({$parts})";
            }
        }

        if (isset($_REQUEST['length']) and isset($_REQUEST['start']))
            $LIMIT = "{$_REQUEST['start']},{$_REQUEST['length']}";
    }

    $order_id = 0;
    $where_user = " and user_id = '{$nowUser['id']}' ";
    if (!empty($_REQUEST['order_id'])) {
        $order_id = (int)$_REQUEST['order_id'];
        if ((!empty($nowUser['access']['store_orders']) and in_array('Все заказы', $nowUser['access']['store_orders'])) or $nowUser['role_id'] == 1)
            $where_user = "";
    }

    $sql_FROM = <<<SQL
FROM store_price
JOIN store_basket ON store_price.id = store_basket.price_id and store_basket.order_id = '{$order_id}' {$where_user}
SQL;


    $total_count = $db->super_query("SELECT COUNT(store_price.id) as total_count " . $sql_FROM);
    $total_count = $total_count['total_count'];

    $filtered_count = $db->super_query("SELECT COUNT(store_price.id) as filtered_count " . $sql_FROM . $WHERE);
    $filtered_count = $filtered_count['filtered_count'];

    $rows = $db->super_query("SELECT 
    store_basket.id, 
    store_price.id as priceId,
    store_price.code,
    store_price.img,
    store_price.price,
    store_price.name,
    store_price.availability,
    
    store_price.store,
    store_price.chapter,
    store_price.subsection,
    store_basket.price as priceBasket, 
    store_basket.amount as amountBasket " . $sql_FROM . $WHERE . $ORDER . " LIMIT {$LIMIT}", true);

    foreach ($rows as &$row) {
        $row['amount'] = (int)$row['amount'];

        if ($nowUser['price_discount'] > 0)
            $row['price'] = (int)$row['price'] - round((int)$row['price'] / 100 * $nowUser['price_discount']);


        if ((!empty($nowUser['access']['store_basket']) && in_array('Менять цену продажи', $nowUser['access']['store_basket'])) || $nowUser['role_id'] == 1) {
            $row['priceBasket'] = <<<HTML
<div class="input-group input-group-sm  priceBasketControl">
    <input data-id="{$row['id']}" type="number" class="form-control" value="{$row['priceBasket']}" >
</div>
HTML;
        }

        $row['basket'] = <<<HTML
<div class="input-group input-group-sm basketControl inBasket">
    <input  data-nomenclature_id="{$row['nomenclatureId']}" data-price="{$row['price']}" data-id="{$row['priceId']}" type="number" class="form-control" value="{$row['amountBasket']}" >
    <button data-nomenclature_id="{$row['nomenclatureId']}" data-price="{$row['price']}" data-id="{$row['priceId']}" class="btn btn-outline-danger btn-xs" type="button">
        <i class='fas fa-shopping-basket'></i>
    </button>
</div>
HTML;
    }

    if (isset($_REQUEST['serverside']) && $_REQUEST['serverside'] == 1) {
        $Res = [
            'data'            => $rows,
            'draw'            => $_REQUEST['draw']++,
            "recordsTotal"    => $total_count,
            'WHERE'           => $order_id,
            "recordsFiltered" => $filtered_count
        ];
    } else {
        $Res = ['data' => $rows];
    }

}

if ($_REQUEST['act'] == 'columnsTable') {

    $columns = getColumns('store_price');

    //такой мапинг просит дататейбл
    $columns_ = [
        ["data" => 'id', "title" => 'id',],
    ];
    foreach ($columns as $col)
        if ($col['show_table'] == 1 and !in_array($col['column_name'], ['priceUSD', 'waiting', 'description_temp']))
            $columns_[] = [
                "data" => $col['column_name'], "title" => $col['title']
            ];

    $columns_[] =
        [
            "data"  => 'priceBasket',
            "title" => "Цена продажи",
        ];

    $columns_[] =
        [
            "data"  => 'basket',
            "title" => "<i class='fas fa-shopping-basket'></i>",
        ];

    $Res = $columns_;
}

if ($_REQUEST['act'] == 'formTable') {

    //$columns = getColumns($tableName);

    if ($_REQUEST['type'] == 'edit') {
        $id = $_REQUEST['id'];
        $sql = <<<SQL
SELECT * FROM {$tableName} WHERE id='{$id}';
SQL;
        $row = $db->super_query($sql);
    }

    $orderTypes = [
        ['name' => 'Отгрузка', 'value' => 'SHIPMENT']
    ];
    if ((!empty($nowUser['access']['store_basket']) and in_array('Заказ перемещение', $nowUser['access']['store_basket'])) or $nowUser['role_id'] == 1)
        $orderTypes[] = ['name' => 'Перемещение', 'value' => 'MOVE'];


    $columns = [
        ['column_name' => 'id',],
        ['column_name' => 'Comment', 'show_form' => 1, 'form_type' => 'input', 'title' => 'Комментарий', 'val' => ''],
        ['column_name' => 'type', 'show_form' => 1, 'form_type' => 'selectTable', 'title' => 'Тип', 'val' => 'SHIPMENT', 'selectList' => $orderTypes]
    ];

    if (empty($nowUser['client_id'])) {

        $where_manager = '';
        if ((!empty($nowUser['access']['store_orders']) and !in_array('Все клиенты', $nowUser['access']['store_orders'])) and $nowUser['role_id'] != 1)
            $where_manager = " and manager_id = '{$nowUser['id']}'  ";

        if (!empty($nowUser['access']['store_orders']) and !in_array('Видит заказы своих клиентов', $nowUser['access']['store_orders']))
            $where_manager = " and manager_id = '{$nowUser['id']}'  ";

        $clients = $db->super_query("SELECT id as value, title as name FROM store_clients WHERE 1=1 {$where_manager}", true);
        $columns[] = ['column_name' => 'type', 'show_form' => 1, 'form_type' => 'selectTable', 'title' => 'Клиент', 'val' => '0', 'selectList' => $clients];
    }


    $Res = $columns;
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
