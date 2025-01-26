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


        }
        $values = implode(', ', $arr['values']);
        $fields = implode(', ', $arr['fields']);
        $db->query("INSERT INTO {$tableName} ({$fields}) VALUES ({$values}) ;");


        header("Location: /crm.php?mod=" . $mod);
        die();
    }
    if ($id > 0 and $_POST['submit'] == 'edit') {
        $columns = getColumns($tableName);
        $strWhere = " id = '{$id}'";
        $arr = [];
        foreach ($columns as $field) {
            if ($field['column_name'] !== 'id' and isset($_POST[$field['column_name']]))
                $arr[] = " {$field['column_name']} = '{$_POST[$field['column_name']]}' ";

        }
        $argsStr = implode(", ", $arr);
        $sql = <<<SQL
UPDATE {$tableName} SET {$argsStr} WHERE {$strWhere} ;
SQL;

        $db->query($sql);
        header("Location: /crm.php?mod=" . $mod);
        die();
    }
}

if ($_REQUEST['act'] == 'data') {

    $sql_ORDER = '';
    $sql_WHERE = [];
    $LIMIT = 100;

    $sql_JOIN = [];
    $sql_COLUMNS = '';
    $sql_WHERE_OR = [];

    if ($nowUser['role_id'] != 1) {
        if (empty($nowUser['access']['store_orders']))
            $sql_WHERE[] = " store_users.id = '{$nowUser['id']}'  ";
        else if ((!in_array('Все заказы', $nowUser['access']['store_orders']) and !in_array('Видит заказы своих клиентов', $nowUser['access']['store_orders'])))
            $sql_WHERE[] = " store_users.id = '{$nowUser['id']}'  ";
        else if (in_array('Видит заказы своих клиентов', $nowUser['access']['store_orders']))
            $sql_WHERE[] = " store_orders.client_id IN (SELECT client_id FROM store_clients WHERE manager_id = '{$nowUser['id']}')  ";
    }


    DataTable::applyLimit($_REQUEST, $LIMIT);

    if (!empty($_REQUEST['order']))
        DataTable::applyOrder($_REQUEST['columns'], $_REQUEST['order'], [], $sql_ORDER);// разрешаем сортировать только определённые поля

    if (isset($_REQUEST['filter']))
        DataTable::applyFilter([
            'type'          => ["where" => " store_orders.type IN ('{value}')  "],
            'payment_type'  => ["where" => " store_orders.payment_type IN ('{value}')  "],
            'shipment_type' => ["where" => " store_orders.shipment_type IN ('{value}')  "],
            'user_id'       => ["where" => " store_orders.user_id IN ('{value}')  "],
            'status_id'     => ["where" => " store_orders.status_id IN ('{value}')  "],
            'City'          => ["where" => " store_users.City IN ('{value}')  "]
        ], $_REQUEST['filter'], $sql_WHERE, $sql_JOIN);

    if ((isset($_REQUEST['search']['value']) and strlen(trim($_REQUEST['search']['value'])) >= 3))
        if (is_numeric($_REQUEST['search']['value']))
            DataTable::applySearch([
                'id' => ["where" => " store_orders.id ='{value}' "]
            ], trim($_REQUEST['search']['value']), $sql_WHERE, $sql_JOIN);
        else
            DataTable::applySearch([
                'name' => ["where" => " (store_users.col_2 LIKE '%{value}%' OR store_users.col_1 LIKE '%{value}%') "]
            ], trim($_REQUEST['search']['value']), $sql_WHERE, $sql_JOIN);

    if (!empty($sql_WHERE))
        $sql_WHERE = ' WHERE ' . implode(' AND ', $sql_WHERE);
    else $sql_WHERE = '';


    $sql_FROM = "FROM store_orders
JOIN store_users ON store_users.id = store_orders.user_id 
JOIN store_users_roles ON store_users_roles.id = store_users.role_id 
JOIN store_orders_status ON store_orders_status.id = store_orders.status_id
" . implode(' ', $sql_JOIN);

    $Res = $db->super_query("SELECT (SELECT COUNT(store_orders.id) as recordsTotal    {$sql_FROM}) as recordsTotal, 
                                    (SELECT COUNT(store_orders.id) as recordsFiltered {$sql_FROM} {$sql_WHERE}) as recordsFiltered");
    $Res['draw'] = $_REQUEST['draw']++;
    $Res['data'] = [];
    $Res['access'] = $nowUser['access'];
    $Res['$sql_WHERE'] = $sql_WHERE;

    if (!empty($Res['recordsFiltered'])) {
        $Res['data'] = $db->super_query("SELECT 
        store_orders.id,
        store_orders.client_id,
        store_orders.date,
        -- store_orders.status_id,
        store_orders.Comment,
        store_orders.type,
        store_orders.payment_type,
        store_orders.shipment_type,
        (SELECT  SUM(price*amount) as total  FROM store_basket WHERE order_id = store_orders.id ) as total, store_users.col_2 as user_id,
        store_users.City, 
        store_users_roles.name as user_role,
        store_orders_status.name as status_id
        {$sql_COLUMNS} {$sql_FROM} {$sql_WHERE} {$sql_ORDER} LIMIT {$LIMIT}", true);

        $columns = getColumns($tableName);
        fillTableSelectableValue($columns, $Res['data']);

        //  foreach ($Res['data'] as &$row) {     }
    }
}

if ($_REQUEST['act'] == 'columnsTable') {

    $columns = getColumns($tableName);
    $columns_ = [
        ["data" => null, "title" => '', "defaultContent" => "<button class='btn btn-outline-secondary btn-xs btnEdit' data-toggle='modal' data-target='#modal_form_edit'  > <i class='fas fa-edit'></i> </button>"],
        ["data" => 'id', "title" => 'id',],
        ["data" => 'user_role', "title" => 'Роли'],
        ["data" => 'City', "title" => 'Город']
    ];

    foreach ($columns as $col) {
        // Условие для пропуска колонки 'type'  для пользователей с ролью 8 и 10 (Оптовый и розн клиент)
        if (in_array($nowUser['role_id'], [8, 10]) && $col['column_name'] == 'type')
            continue;

        if ($col['show_table'] == 1)
            $columns_[] = [
                "data" => $col['column_name'], "title" => $col['title']
            ];
    }

    $Res = $columns_;
}

if ($_REQUEST['act'] == 'formTable') {

    $columns = getColumns($tableName);

    if ($_REQUEST['type'] == 'edit') {
        $id = (int)$_REQUEST['id'];
        $row = $db->super_query("SELECT * FROM {$tableName} WHERE id='{$id}'");

        $basket = $db->super_query("SELECT store_price.*, store_basket.amount as amountBasket, store_basket.price as priceBasket FROM store_price
                                    JOIN store_basket ON store_price.id = store_basket.price_id and order_id = '{$id}'", true);

        $basket_table_structure = [
            'code'         => 'Номенклатура',
            'name'         => 'Название',
            'chapter'      => 'Раздел',
            'subsection'   => 'Категория',
            'store'        => 'Склад',
            'availability' => 'Наличие',
            'amountBasket' => 'Заказано',
            'priceBasket'  => 'Цена',
        ];

        $row['Корзина'][] = array_values($basket_table_structure);
        $total = 0;
        $count_items = 0;
        foreach ($basket as $row_) {
            $basket_row = [];
            $count_items += $row_['amount'];
            $total += $row_['priceBasket'] * $row_['amountBasket'];
            foreach (array_keys($basket_table_structure) as $field)
                $basket_row[] = $row_[$field];
            $row['Корзина'][] = $basket_row;
        }
        $row['Корзина'][] = ['', '', '', '', '', "<b>{$count_items}</b>", '', "<b>{$total}</b>"];
    }

    $columns[] = ['column_name' => 'Корзина', 'form_type' => 'table', 'show_form' => 1, 'title' => '<a href="/crm.php?mod=store_basket&order_id=' . $id . '">Корзина</a>'];


    $hideTypeSelector = in_array($nowUser['role_id'], [8, 10]);

    $myClients = [];
    if (!empty($nowUser['access']['store_orders']) and in_array('Видит заказы своих клиентов', $nowUser['access']['store_orders'])) {
        $rows = $db->super_query("SELECT * FROM store_clients WHERE manager_id = '{$nowUser['id']}';", true);
        foreach ($rows as $row)
            $myClients[$row['id']] = $row['title'];
    }


    foreach ($columns as &$col) {
        if ($col['show_form'] > 0) {

            if ($col['column_name'] == 'client_id' and !empty($myClients)) {
                $list = [];
                foreach ($col['selectList'] as $item)
                    if (!empty($myClients[$item['value']]))
                        $list[] = $item;
                $col['selectList'] = $list;
            }

            if ($hideTypeSelector && $col['column_name'] == 'type') {
                $col['show_form'] = 0;
            } else {
                $col['val'] = isset($row[$col['column_name']]) ? $row[$col['column_name']] : false;
            }
        }
    }

    $Res = $columns;
}

if ($_REQUEST['act'] == 'getFilters') {

    $sql = <<<SQL
SELECT store_users.col_2 as `value`,store_users.id as `id`,'user_id' as `field`,  count(user_id) as `count`, 'Пользователь' as des
FROM store_orders 
LEFT JOIN store_users ON store_users.id = store_orders.user_id
WHERE 1=1
GROUP BY `user_id`
UNION
SELECT store_orders_status.name as `value`,store_orders_status.id as `id`,'status_id' as `field`, count(status_id) as `count`, 'Статус' as des 
FROM store_orders 
LEFT JOIN store_orders_status ON store_orders_status.id = store_orders.status_id
WHERE 1=1 
GROUP BY `status_id`
UNION 
SELECT type as `value`,type as `id`, 'type' as `field`, count(id) as `count`, 'Тип' as des 
FROM store_orders 
GROUP BY `type`
UNION 
SELECT City as `value`,City as `id`, 'City' as `field`, count(store_orders.id) as `count`, 'Город' as des 
FROM store_users
JOIN store_orders ON store_orders.user_id = store_users.id
GROUP BY `City`
/*UNION 
SELECT payment_type as `value`,type as `id`, 'payment_type' as `field`, count(id) as `count`, 'Тип Оплаты' as des 
FROM store_orders 
GROUP BY `payment_type`
UNION 
SELECT shipment_type as `value`,type as `id`, 'shipment_type' as `field`, count(id) as `count`, 'Тип Отгрузки' as des 
FROM store_orders 
GROUP BY `shipment_type`*/
SQL;

    $filters = [];
    $rows = $db->super_query($sql, true);

    foreach ($rows as $row) {
        if (!isset($filters[$row['field']]))
            $filters[$row['field']] = ['list' => [], 'des' => $row['des']];

        if (empty($row['id'])) {
            $value = urlencode($row['value'] ? $row['value'] : 'пусто');
        } else $value = $row['id'];

        $filters[$row['field']]['list'][] = [
            'value' => $value,
            'name'  => $row['value'] ? $row['value'] : 'пусто',
            'count' => $row['count'],
            'des'   => $row['des']
        ];
    }

    $Res['filters'] = $filters;
}

if ($_REQUEST['act'] == 'getStats') {

    $sql = <<<SQL
SELECT COUNT(DISTINCT price_id) as count_position, SUM(price*amount) as total
FROM store_basket
WHERE store_basket.order_id = 0 and user_id = '{$nowUser['id']}'
SQL;

    $total_basket = $db->super_query($sql);


    $Res = [
        ['label' => "Прайс <span class='badge badge-danger'></span>",
         'url'   => '/crm.php?mod=store_price'],

        ['label' => "Корзина <span class='badge badge-danger'>{$total_basket['count_position']}</span> на {$total_basket['total']}р.",
         'url'   => '/crm.php?mod=store_basket'],


        /*['label' => 'Обновлен', 'val' => $stats['lastUpdate']],*/
    ];
}
