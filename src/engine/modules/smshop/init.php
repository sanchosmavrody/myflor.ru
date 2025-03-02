<?php

$shop_catalog = $_REQUEST['shop_catalog'];


require_once ROOT_DIR . '/engine/classes/smshop/include.php';


$Catalog = new Catalog('catalog_' . $shop_catalog);
$Res = $Catalog->getList();

//header('Content-Type: application/json; charset=UTF-8');
//echo json_encode($Res);
//exit();

$tpl->load_template('/smshop/catalog/shortstory.tpl');

foreach ($Res['data'] as $item) {

    $item['photos'] = explode(',', $item['photos']);
    $item['photo_main'] = empty($item['photos'][0]) ? '/templates/Full/images/catalog_auto_no_photo.png' : $item['photos'][0];


    foreach ($item as $fields => $value)
        if (is_array($value))
            foreach ($value as $sub_fields => $sub_value)
                $tpl->set('{' . $fields . '.' . $sub_fields . '}', $sub_value);
        else
            $tpl->set('{' . $fields . '}', $value);


    $tpl->set('{' . $fields . '}', $value);
    //photo_main

    $tpl->compile('items');
}


$tpl->load_template('/smshop/catalog/main.tpl');


$tpl->load_template('/smshop/catalog/main.tpl');
$tpl->set('{items}', $tpl->result['items']);//$tpl->result['items']
$tpl->compile('content');
//echo $tpl->result['content'];

