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


        header("Location: /crm.php?mod=" . $mod);
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
        header("Location: /crm.php?mod=" . $mod);
        die();
    }
}

if ($_REQUEST['act'] == 'data') {

    $columns = getColumns($tableName);
    $columns_replace_from_list = [];
    foreach ($columns as $column)
        if ($column['form_type'] == 'selectTable')
            $columns_replace_from_list[$column['column_name']] = $column;


    if (isset($_REQUEST['search']['value'])) $searchValue = trim($_REQUEST['search']['value']);

    $ORDER = '';
    $WHERE = ' WHERE 1 = 1 ';
    $LIMIT = 100;

    if (isset($_REQUEST['serverside']) and $_REQUEST['serverside'] == 1) {
        if (isset($_REQUEST['order'][0]) and $_REQUEST['columns'][$_REQUEST['order'][0]['column']]['data'])
            $ORDER = " ORDER BY {$_REQUEST['columns'][$_REQUEST['order'][0]['column']]['data']} {$_REQUEST['order'][0]['dir']} ";

        if ((isset($searchValue) and strlen($searchValue) > 3) or isset($_REQUEST['filter'])) {

            $filtersToSearch = [
                'id' => "='{$searchValue}'"
            ];

            $parts = [];
            foreach ($filtersToSearch as $field => $sqlStr)
                if (isset($_REQUEST['filter']) and $_REQUEST['filter'][$field])
                    $WHERE .= " AND {$tableName}.{$field}='{$_REQUEST['filter'][$field]}'";
                else if ((isset($searchValue) and strlen($searchValue) > 3))
                    $parts[] = "{$tableName}.{$field} {$sqlStr}";

            if (count($parts)) {
                $parts = implode(' OR ', $parts);
                $WHERE .= " AND ({$parts})";
            }
        }

        if (isset($_REQUEST['length']) and isset($_REQUEST['start']))
            $LIMIT = "{$_REQUEST['start']},{$_REQUEST['length']}";
    }

    $sql_FROM = <<<SQL
FROM {$tableName}
SQL;

    $total_count = $db->super_query("SELECT COUNT({$tableName}.id) as total_count " . $sql_FROM);
    $total_count = $total_count['total_count'];

    $filtered_count = $db->super_query("SELECT COUNT({$tableName}.id) as filtered_count " . $sql_FROM . $WHERE);
    $filtered_count = $filtered_count['filtered_count'];

    //Роль|1|1|selectTable=store_users_roles,id,name
    $rows = $db->super_query("SELECT {$tableName}.*, 
       (SELECT GROUP_CONCAT(name) as images FROM `store_images` WHERE  module ='{$tableName}' and  `object_id` = {$tableName}.id AND type = 'THUMB') as images "
        . $sql_FROM . $WHERE . $ORDER . " LIMIT {$LIMIT}", true);

    foreach ($rows as &$row) {
        if (!empty($row['images'])) {
            $row['img'] = explode(',', $row['images']);
            $img = [];
            foreach ($row['img'] as $item)
                $img[] = "<img src='{$item}' style='width: 20px'>";

            $row['img'] = implode('', $img);
        }

        if (!empty($columns_replace_from_list))
            foreach ($row as $field => &$value) {
                if (!empty($columns_replace_from_list[$field]))
                    getValueFromTableList($columns_replace_from_list[$field]['selectList'], $value);

            }
    }

    if (isset($_REQUEST['serverside']) and $_REQUEST['serverside'] == 1)
        $Res = ['data'            => $rows, "draw" => $_REQUEST['draw']++,
                "recordsTotal"    => $total_count,
                'WHERE'           => $columns,
                "recordsFiltered" => $filtered_count];
    else
        $Res = ['WHERE' => $columns, 'data' => $rows];

}

if ($_REQUEST['act'] == 'columnsTable') {

    $columns = getColumns($tableName);

    //такой мапинг просит дататейбл
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
    foreach ($columns as $col)
        if ($col['show_table'] == 1)
            $columns_[] = [
                "data" => $col['column_name'], "title" => $col['title']
            ];

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

    foreach ($columns as &$col)
        if ($col['show_form'] > 0)
            $col['val'] = isset($row[$col['column_name']]) ? $row[$col['column_name']] : false;

    $Res = $columns;
}
