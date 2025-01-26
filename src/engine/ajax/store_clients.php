<?php


$Res = [];
$fieldSetting = ['title', 'show_table', 'show_form', 'form_type',];
$tableName = $_REQUEST['mod'];
$mod = $_REQUEST['mod'];


if (isset($_POST['id'])) {

    $_POST['phone'] = cleanPhone($_POST['phone']);
    $id = $_POST['id'];
    if ($id == 0 and $_POST['submit'] == 'add') {
        $columns = getColumns($tableName);

        $db->query("INSERT INTO store_users (role_id,col_2,col_1,col_3,City,price_discount,col_5) 
                    VALUES (8,'{$_POST['name']}','{$_POST['phone']}','{$_POST['col_3']}','{$_POST['City']}','{$_POST['price_discount']}','Да') ;");

        $user_id = $db->insert_id();
        $arr = ['fields' => ['user_id'], 'values' => ["'{$user_id}'"]];

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


        $db->query("UPDATE {$tableName} SET {$argsStr} WHERE {$strWhere}");


        $db->query("UPDATE store_users SET 
                     col_2='{$_POST['name']}',
                     col_1='{$_POST['phone']}',
                     col_3='{$_POST['col_3']}',
                     City='{$_POST['City']}',
                     price_discount='{$_POST['price_discount']}'
                     WHERE id = (SELECT user_id FROM store_clients WHERE id = '{$id}');");

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

    if ((empty($nowUser['access']['store_clients']) or !in_array('Все клиенты', $nowUser['access']['store_clients'])) and $nowUser['role_id'] != 1)
        $sql_WHERE[] = " store_clients.manager_id = '{$nowUser['id']}'  ";

    DataTable::applyLimit($_REQUEST, $LIMIT);

    if (!empty($_REQUEST['order']))
        DataTable::applyOrder($_REQUEST['columns'], $_REQUEST['order'], [], $sql_ORDER);// разрешаем сортировать только определённые поля

    if (isset($_REQUEST['filter']))
        DataTable::applyFilter([
            'type' => ["where" => " store_clients.type IN ('{value}')  "],
            'City' => ["where" => " store_users.City IN ('{value}')  "]
        ], $_REQUEST['filter'], $sql_WHERE, $sql_JOIN);

    if ((isset($_REQUEST['search']['value']) and strlen(trim($_REQUEST['search']['value'])) >= 3))
        DataTable::applySearch([
            'name' => ["where" => " (store_users.col_2 LIKE '%{value}%' OR store_users.col_1 LIKE '%{value}%') "]
        ], trim($_REQUEST['search']['value']), $sql_WHERE, $sql_JOIN);

    if (!empty($sql_WHERE))
        $sql_WHERE = ' WHERE ' . implode(' AND ', $sql_WHERE);
    else $sql_WHERE = '';


    $sql_FROM = "FROM store_clients
JOIN store_users ON store_users.id = store_clients.user_id and store_users.role_id = 8
" . implode(' ', $sql_JOIN);

    $Res = $db->super_query("SELECT (SELECT COUNT(store_clients.id) as recordsTotal    {$sql_FROM}) as recordsTotal, 
                                    (SELECT COUNT(store_clients.id) as recordsFiltered {$sql_FROM} {$sql_WHERE}) as recordsFiltered");
    $Res['draw'] = $_REQUEST['draw']++;
    $Res['data'] = [];
    if (!empty($Res['recordsFiltered'])) {
        $Res['data'] = $db->super_query("SELECT 
        store_clients.*, store_users.City, store_users.col_1 as phone, store_users.col_2 as name, store_users.price_discount 
        {$sql_COLUMNS} {$sql_FROM} {$sql_WHERE} {$sql_ORDER} LIMIT {$LIMIT}", true);

        $columns = getColumns($tableName);
        fillTableSelectableValue($columns, $Res['data']);
        //  foreach ($Res['data'] as &$row) {     }
    }
}

if ($_REQUEST['act'] == 'columnsTable') {

    $columns = getColumns($tableName);
    $columns_ = [
        ["data"           => null, "title" => '',
         "defaultContent" => "<button class='btn btn-outline-secondary btn-xs btnEdit' data-toggle='modal' data-target='#modal_form_edit'  > <i class='fas fa-edit'></i> </button>"],
        ["data" => 'id', "title" => 'id',],
        ["data" => 'phone', "title" => 'Телефон'],
        ["data" => 'name', "title" => 'Ответственный'],
        ["data" => 'City', "title" => 'Город'],
        ["data" => 'price_discount', "title" => 'Скидка']
    ];

    foreach ($columns as $col) {
        if ($col['show_table'] == 1)
            $columns_[] = [
                "data" => $col['column_name'], "title" => $col['title']
            ];
    }


    $Res = $columns_;
}

if ($_REQUEST['act'] == 'formTable') {

    $columns = getColumns($tableName);
    $columns[] = ['column_name' => 'name', 'form_type' => 'input', 'show_form' => 1, 'title' => 'Ответственный', "val" => false];
    $columns[] = ['column_name' => 'phone', 'form_type' => 'input', 'show_form' => 1, 'title' => 'Телефон', "val" => false];
    $columns[] = ['column_name' => 'col_3', 'form_type' => 'password', 'show_form' => 1, 'title' => 'Пароль', "val" => false];
    $columns[] = ['column_name' => 'City', 'form_type' => 'input', 'show_form' => 1, 'title' => 'Город', "val" => false];
    $columns[] = ['column_name' => 'price_discount', 'form_type' => 'input', 'show_form' => 1, 'title' => 'Скидка', "val" => false];

    if ($_REQUEST['type'] == 'edit') {
        $id = (int)$_REQUEST['id'];
        $row = $db->super_query("SELECT
        store_clients.*, store_users.City, store_users.col_1 as phone, store_users.col_2 as name, store_users.col_3, store_users.price_discount 
FROM {$tableName}
JOIN store_users ON store_users.id = store_clients.user_id and store_users.role_id = 8
WHERE {$tableName}.id='{$id}'");

    }
    foreach ($columns as &$col)
        if ($col['show_form'] > 0)
            $col['val'] = isset($row[$col['column_name']]) ? $row[$col['column_name']] : false;


    if ($nowUser['role_id'] == 7)
        $columns[2]['val'] = $nowUser['id'];

    $Res = $columns;
}

if ($_REQUEST['act'] == 'getFilters') {

    $sql = <<<SQL
SELECT City as `value`,City as `id`, 'City' as `field`, count(store_users.id) as `count`, 'Город' as des 
FROM store_users
GROUP BY `City`
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