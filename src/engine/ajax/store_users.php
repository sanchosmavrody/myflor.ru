<?php

$Res = [];
$fieldSetting = ['title', 'show_table', 'show_form', 'form_type'];
$tableName = $_REQUEST['mod'];
$mod = $_REQUEST['mod'];

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if ($id == 0 && $_POST['submit'] == 'add') {
        $columns = getColumns($tableName);

        $arr = [];
        foreach ($columns as $field) {
            if ($field['column_name'] !== 'id' && $field['form_type'] != 'img' && isset($_POST[$field['column_name']])) {
                $arr['fields'][] = "{$field['column_name']}";
                $arr['values'][] = "'{$_POST[$field['column_name']]}'";
            }
        }
        $values = implode(', ', $arr['values']);
        $fields = implode(', ', $arr['fields']);
        $db->query("INSERT INTO {$tableName} ({$fields}) VALUES ({$values});");

        header("Location: /crm.php?mod=" . $mod);
        die();
    }

    if ($id > 0 && $_POST['submit'] == 'edit') {


        $_POST['col_1'] = cleanPhone($_POST['col_1']);
        $columns = getColumns($tableName);
        $strWhere = "id = '{$id}'";
        $arr = [];
        foreach ($columns as $field) {
            if ($field['column_name'] !== 'id' && $field['form_type'] != 'img' && isset($_POST[$field['column_name']])) {
                $arr[] = "{$field['column_name']} = '{$_POST[$field['column_name']]}'";
            }
        }
        $argsStr = implode(", ", $arr);
        $sql = <<<SQL
UPDATE {$tableName} SET {$argsStr} WHERE {$strWhere};
SQL;

        $db->query($sql);
        header("Location: /crm.php?mod=" . $mod);
        die();
    }
}

if ($_REQUEST['act'] == 'data') {
    $columns = getColumns($tableName);
    $columns_replace_from_list = [];
    foreach ($columns as $column) {
        if ($column['form_type'] == 'selectTable') {
            $columns_replace_from_list[$column['column_name']] = $column;
        }
    }

    if (isset($_REQUEST['search']['value'])) {
        $searchValue = trim($_REQUEST['search']['value']);
    }

    $ORDER = '';
    $WHERE = ' WHERE 1 = 1 ';
    $LIMIT = 100;

    if (isset($_REQUEST['serverside']) && $_REQUEST['serverside'] == 1) {
        $ORDER = getSortSql($_REQUEST['order'], $_REQUEST['columns']);

        if ((isset($searchValue) && strlen($searchValue) > 3) || isset($_REQUEST['filter'])) {
            $filtersToSearch = [
                'id'    => "='{$searchValue}'",
                'City'  => " LIKE '%{$searchValue}%'",
                'col_5' => " LIKE '%{$searchValue}%'",
                'col_2' => " LIKE '%{$searchValue}%'",
                'col_1' => " LIKE '%{$searchValue}%'",
            ];

            $parts = [];
            foreach ($filtersToSearch as $field => $sqlStr) {
                if (isset($_REQUEST['filter']) && $_REQUEST['filter'][$field]) {
                    $WHERE .= " AND {$tableName}.{$field} IN ('" . prepareFilterValue($_REQUEST['filter'][$field], 'Не закреплен') . "')";
                } else if ((isset($searchValue) && strlen($searchValue) > 3 && $sqlStr)) {
                    $parts[] = "{$tableName}.{$field} {$sqlStr}";
                }
            }

            if (count($parts)) {
                $parts = implode(' OR ', $parts);
                $WHERE .= " AND ({$parts})";
            }
        }

        if (isset($_REQUEST['length']) && isset($_REQUEST['start'])) {
            $LIMIT = "{$_REQUEST['start']},{$_REQUEST['length']}";
        }
    }

    $sql_FROM = <<<SQL
FROM {$tableName}
SQL;

    $total_count = $db->super_query("SELECT COUNT({$tableName}.id) as total_count " . $sql_FROM);
    $total_count = $total_count['total_count'];

    $filtered_count = $db->super_query("SELECT COUNT({$tableName}.id) as filtered_count " . $sql_FROM . $WHERE);
    $filtered_count = $filtered_count['filtered_count'];

    $rows = $db->super_query("SELECT {$tableName}.* " . $sql_FROM . $WHERE . $ORDER . " LIMIT {$LIMIT}", true);

    foreach ($rows as &$row) {
        if (!empty($columns_replace_from_list)) {
            foreach ($row as $field => &$value) {
                if (!empty($columns_replace_from_list[$field])) {
                    getValueFromTableList($columns_replace_from_list[$field]['selectList'], $value);
                }
            }
        }
    }

    if (isset($_REQUEST['serverside']) && $_REQUEST['serverside'] == 1) {
        $Res = [
            'data'            => $rows,
            "draw"            => $_REQUEST['draw']++,
            "recordsTotal"    => $total_count,
            'WHERE'           => $columns,
            "recordsFiltered" => $filtered_count
        ];
    } else {
        $Res = ['WHERE' => $columns, 'data' => $rows];
    }
}

if ($_REQUEST['act'] == 'columnsTable') {
    $columns = getColumns($tableName);

    $columns_ = [
        [
            "data"           => null,
            "title"          => '',
            "defaultContent" => "<button class='btn btn-outline-secondary btn-xs btnEdit' data-toggle='modal' data-target='#modal_form_edit'> <i class='fas fa-edit'></i> </button>"
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

    $Res = $columns_;
}

if ($_REQUEST['act'] == 'formTable') {
    $columns = getColumns($tableName);

    if ($_REQUEST['type'] == 'edit') {
        $id = $_REQUEST['id'];
        $sql = <<<SQL
SELECT * FROM {$tableName} WHERE id='{$id}';
SQL;
        $row = $db->super_query($sql);
    }

    foreach ($columns as &$col) {
        if ($col['show_form'] > 0) {
            $col['val'] = isset($row[$col['column_name']]) ? $row[$col['column_name']] : false;
        }
    }

    $Res = $columns;
}

if ($_REQUEST['act'] == 'getFilters') {
    $sql = <<<SQL
SELECT col_5 as `value`, col_5 as `id`, 'col_5' as `field`, count(id) as `count`, 'Активность' as des 
FROM store_users 
GROUP BY `col_5`
UNION
SELECT DISTINCT City as `value`, City as `id`, 'City' as `field`, count(id) as `count`, 'Городa' as des 
FROM store_users 
GROUP BY `City`
SQL;

    $filters = [];
    $rows = $db->super_query($sql, true);

    foreach ($rows as $row) {
        if (!isset($filters[$row['field']])) {
            $filters[$row['field']] = ['list' => [], 'des' => $row['des']];
        }

        $value = empty($row['id']) ? urlencode($row['value'] ? $row['value'] : 'Не указано') : $row['id'];

        $filters[$row['field']]['list'][] = [
            'value' => $value,
            'name'  => $row['value'] ? $row['value'] : 'Не указано',
            'count' => $row['count'],
            'des'   => $row['des']
        ];
    }

    $Res['filters'] = $filters;
}

