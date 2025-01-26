<?php
session_start();
if (empty($_SESSION['nowUser'])) {
    die();
} else {
    $nowUser = $_SESSION['nowUser'];
}

if (isset($_REQUEST['mod'])) {


    @error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
    @ini_set('display_errors', true);
    @ini_set('html_errors', false);
    @ini_set('error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE);

    define('DATALIFEENGINE', true);
    define('ROOT_DIR', substr(dirname(__FILE__), 0, -12));
    define('ENGINE_DIR', ROOT_DIR . '/engine');

    include ENGINE_DIR . '/data/config.php';
    include(ENGINE_DIR . '/data/shopconfig.php');

    date_default_timezone_set($config['date_adjust']);

    require_once ENGINE_DIR . '/classes/mysql.php';
    require_once ENGINE_DIR . '/classes/helpers.class.php';

    require_once ENGINE_DIR . '/data/dbconfig.php';
    require_once ENGINE_DIR . '/modules/functions.php';
    require_once ENGINE_DIR . '/modules/sitelogin.php';

    function cleanPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) == 10) {
            $phone = '7' . $phone;
        } else if (strlen($phone) == 11 and (substr($phone, 0, 1) == '7' or substr($phone, 0, 1) == '8')) {
            $phone = '7' . substr($phone, 1);
        } else if (strlen($phone) == 12) {
            $phone = '7' . substr($phone, 2);
        }

        return $phone;
    }

    function uploadImg($object_id, $module_name, $column)
    {
        global $db, $config;
        include_once ENGINE_DIR . '/classes/thumb.class.php';
        $config['watermark_seite'] = 5;

        // $_POST['img[]']  [string]
        // 1. получить все фотки по id объёкта
        // 2. перебирая их првоеряем есть их name в $_POST['img[]']
        // 3. есть - ничего не делаем
        // 4. нету - тушим с диска по названию
        // 5. тушим из базы по id фотки

        $column = $column . '_upload';

        $sort = 0;

        $imageMaxSort = $db->super_query("SELECT MAX(sort) as sort FROM store_images WHERE module = '{$module_name}' and  object_id={$object_id} 
                                           and type = 'ORIGINAL'  LIMIT 1 ");

        $sort = $imageMaxSort['sort'];

        if (isset($_FILES[$column]) and count($_FILES[$column]['name']) > 0) {

            $filePath = "/uploads/{$module_name}/{$object_id}/";
            if (!file_exists(ROOT_DIR . $filePath))
                if (!mkdir(ROOT_DIR . $filePath, 0777, true))
                    die('бля..');
            $filePathThumbs = $filePath . "thumbs/";
            if (!file_exists(ROOT_DIR . $filePathThumbs))
                if (!mkdir(ROOT_DIR . $filePathThumbs, 0777, true))
                    die('бля2..');

            $ret = [];

            $countfiles = count($_FILES[$column]['name']);
            for ($i = 0; $i < $countfiles; $i++) {
                $sort++;
                $ty = explode('.', $_FILES[$column]['name'][$i]);
                $fileNameOiginal = $i . uniqid() . '.' . $ty[count($ty) - 1];
                $res = move_uploaded_file($_FILES[$column]['tmp_name'][$i], ROOT_DIR . $filePath . $fileNameOiginal);
                if ($res) {
                    $ret[] = $filePath . $fileNameOiginal;

                    $ty = explode('.', $fileNameOiginal);
                    $fileNameMain = '_' . $i . uniqid() . '.' . end($ty);

                    //############################# $main
                    $thumb = new thumbnail(ROOT_DIR . $filePath . $fileNameOiginal);
                    $thumb->size_auto('1200', 2);
                    $thumb->jpeg_quality($config['jpeg_quality']);
                    $thumb->insert_watermark(150, '/watermark.png', '/watermark.png');
                    $thumb->save(ROOT_DIR . $filePath . $fileNameMain);

                    //############################# $thumb
                    $thumb = new thumbnail(ROOT_DIR . $filePath . $fileNameOiginal);
                    $thumb->size_auto('600x600', 2);
                    $thumb->jpeg_quality($config['jpeg_quality']);
                    $thumb->insert_watermark(150, '/watermark_thumb.png', '/watermark_thumb.png');
                    $thumb->save(ROOT_DIR . $filePathThumbs . $fileNameMain);

                    $db->query("INSERT IGNORE INTO store_images (sort,module,object_id,name,type) VALUES ('{$sort}','{$module_name}','{$object_id}','{$filePath}{$fileNameOiginal}','ORIGINAL');");
                    $original_id = $db->insert_id();
                    $db->query("INSERT IGNORE INTO store_images (sort,module,object_id,original_id,name,type) VALUES ('{$sort}','{$module_name}','{$object_id}','{$original_id}','{$filePath}{$fileNameMain}','MAIN');");
                    $db->query("INSERT IGNORE INTO store_images (sort,module,object_id,original_id,name,type) VALUES ('{$sort}','{$module_name}','{$object_id}','{$original_id}','{$filePathThumbs}{$fileNameMain}','THUMB');");
                }
            }
            return $ret;
        } else return false;
    }

    function uploadFile($object_id, $module_name, $column)
    {
        global $db, $config;

        $column = $column . '_upload';

        $imageMaxSort = $db->super_query("SELECT MAX(sort) as sort FROM store_files WHERE module = '{$module_name}' and  object_id={$object_id}  LIMIT 1 ");
        $sort = $imageMaxSort['sort'];

        if (isset($_FILES[$column]) and count($_FILES[$column]['name']) > 0) {

            $filePath = "/uploads/{$module_name}/{$object_id}/";


            if (!file_exists(ROOT_DIR . $filePath))
                if (!mkdir(ROOT_DIR . $filePath, 0777, true))
                    die('бля..');
            $filePathThumbs = $filePath . "thumbs/";
            if (!file_exists(ROOT_DIR . $filePathThumbs))
                if (!mkdir(ROOT_DIR . $filePathThumbs, 0777, true))
                    die('бля2..');

            $ret = [];

            $countfiles = count($_FILES[$column]['name']);
            for ($i = 0; $i < $countfiles; $i++) {
                $sort++;
                $ty = explode('.', $_FILES[$column]['name'][$i]);
                $fileNameOiginal = $i . uniqid() . '.' . $ty[count($ty) - 1];
                $res = move_uploaded_file($_FILES[$column]['tmp_name'][$i], ROOT_DIR . $filePath . $fileNameOiginal);

                if ($res) {
                    $ret[] = $filePath . $fileNameOiginal;
                    $db->query("INSERT IGNORE INTO store_files (sort,module,object_id,name) VALUES ('{$sort}','{$module_name}','{$object_id}','{$filePath}{$fileNameOiginal}');");
                    $original_id = $db->insert_id();
                }
            }
            return $ret;
        } else return false;
    }

    function imgFormController($object_id, $mod, $formImages, $type)
    {
        global $db;
        //1. поулчить текущий список картинок у объекта
        //2. сравнить с тем что пришёл с формы - получить id тех что нужно снести
        //3. Получить с базы все зависимые картинки
        //4. Ёбнуть их с диска по name
        //5. ёбнуть с базы по id

        $images = $db->super_query("SELECT id, original_id FROM store_images WHERE module = '{$mod}' and  object_id={$object_id} and type = '{$type}' ", true);

        $toDelete = [];
        $imagesById = [];
        foreach ($images as $image) {
            if (!in_array($image['id'], $formImages))
                $toDelete[] = $image;

            $imagesById[$image['id']] = $image;
        }

        $toDeleteAllCopyByName = [];
        foreach ($toDelete as $imageToDel) {
            $images = $db->super_query("SELECT * FROM store_images WHERE module = '{$mod}' and  (original_id='{$imageToDel['original_id']}' OR id='{$imageToDel['original_id']}') ; ", true);
            foreach ($images as $image)
                $toDeleteAllCopyByName[$image['name']] = $image['id'];
        }

        foreach ($toDeleteAllCopyByName as $name => $id)
            if (file_exists(ROOT_DIR . $name))
                if (unlink(ROOT_DIR . $name))
                    $db->query("DELETE FROM store_images WHERE id = '{$id}'; ");

        foreach ($formImages as $sort => $imageId)
            $db->query("UPDATE store_images SET sort = '{$sort}' 
                WHERE (id = '{$imagesById[$imageId]['original_id']}' OR original_id = '{$imagesById[$imageId]['original_id']}'); ");
    }

    function getValueFromTableList($list, &$value)
    {
        foreach ($list as $item)
            if ($item['value'] === $value)
                $value = $item['name'];
    }

    function fillTableSelectableValue($columns, &$data)
    {
        $lib = [];
        foreach ($columns as $column) {
            if ($column['form_type'] == 'selectTable') {
                $lib[$column['column_name']] = [];
                foreach ($column['selectList'] as $item)
                    $lib[$column['column_name']][$item['value']] = $item['name'];
            }
        }
        foreach ($data as &$row)
            foreach ($lib as $field => $itemSet)
                if (isset($itemSet[$row[$field]]))
                    $row[$field] = $itemSet[$row[$field]];
    }

    function getColumns($tableName, $table_schema = 'elephant-flowers.ru', &$dblink = false)
    {
        global $db;
        $sql = <<<SQL
SELECT column_name,column_comment
FROM information_schema.columns
WHERE table_schema='{$table_schema}' and table_name='{$tableName}';
SQL;

        if ($dblink)
            $columns = $dblink->super_query($sql, true);
        else
            $columns = $db->super_query($sql, true);

        foreach ($columns as &$column) {
            parseSettingColumn($column);

            $columns_[] = [
                "data_field" => $column['column_name'],
                "title"      => $column['title'],
                "form_type"  => $column['form_type'],
                "show_form"  => $column['show_form'],
            ];
        }

        return $columns;
    }

    function prepareFilterValue($value, $emptyTitle = 'Пусто')
    {
        return str_replace(',', "','", urldecode($value == $emptyTitle ? '' : $value));
    }

    function getSortSql($orders, $columns)
    {
        $ORDER = '';
        if (isset($orders[0]) and $columns[$orders[0]['column']]['data'])
            $ORDER = " ORDER BY {$columns[$orders[0]['column']]['data']} {$orders[0]['dir']} ";
        return $ORDER;
    }

    function parseSettingColumn(&$column)
    {
        global $fieldSetting, $db;
        if (!$column['column_comment'])
            return;
        $column_set = explode('|', $column['column_comment']);
        foreach ($fieldSetting as $i => $fieldSet) {
            if ($fieldSet == 'form_type' and mb_stripos($column_set[$i], 'select=') === 0) {
                $column[$fieldSet] = 'select';
                $column['selectList'] = explode('#', str_replace('select=', '', $column_set[$i]));
            } else if ($fieldSet == 'form_type' and mb_stripos($column_set[$i], 'selectTable=') === 0) {
                $column[$fieldSet] = 'selectTable';
                $settings = explode(',', str_replace('selectTable=', '', $column_set[$i])); //tableName,ID field,NAME field,WHERE

                $WHERE = '';
                if (isset($settings[3]))
                    $WHERE = 'WHERE ' . str_replace('"', "'", $settings[3]);// меняем двойные кавычки на одинарные

                $list = $db->super_query("SELECT DISTINCT {$settings[1]},{$settings[2]} FROM {$settings[0]} {$WHERE}", true);
                foreach ($list as $item)
                    $column['selectList'][] = ['value' => $item[$settings[1]], 'name' => $item[$settings[2]]];
            } else
                $column[$fieldSet] = $column_set[$i];
        }
    }

    $row = $db->super_query("SELECT * FROM store_users WHERE  col_1 = '{$nowUser['col_1']}' ");
    $nowUser['price_discount'] = $row['price_discount'];

    if (file_exists(__DIR__ . '/' . $_REQUEST['mod'] . '.php'))
        require_once(__DIR__ . '/' . $_REQUEST['mod'] . '.php');
    else
        require_once(__DIR__ . '/default.php');

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($Res);
} else
    exit('METHOD NO FOUND ' . $_SERVER['DOCUMENT_ROOT'] . '/engine/ajax/shop/' . $_REQUEST['mod'] . '.php');



