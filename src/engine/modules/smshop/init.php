<?php
require_once ROOT_DIR . '/engine/classes/smshop/include.php';

$shop_catalog = $_REQUEST['shop_catalog'];

$state = ['pager' => ['current' => 0, 'limit' => 2], 'sorter' => [], 'filter' => [], 'grouper' => []];

$link_parts = explode('page/', $_REQUEST['url']);
if (!empty($link_parts[1])) {
    $state['pager']['current'] = (int)$link_parts[1] - 1;
    if ($state['pager']['current'] == 0)
        header("location: /{$shop_catalog}/" . $link_parts[0]);
}
$link_parts = explode('/', $link_parts[0]);


$Catalog = new Catalog('shop_' . $shop_catalog);
$Res = $Catalog->getList($state['filter'], $state['pager']);

$state['pager']['filtered'] = $state['pager']['total'] = $Res['pager']['filtered'];

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
    $tpl->compile('items');
}

include 'navigation.php';

$tpl->load_template('/smshop/catalog/main.tpl');
$tpl->set('{items}', $tpl->result['items']);
$tpl->set('{navigation}', $tpl->result['navigation']);
$tpl->compile('content');