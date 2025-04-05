<?php
global $shop_catalog;
$Catalog = new Catalog('shop_' . $shop_catalog);

$state = ['pager' => ['current' => 0, 'limit' => 20], 'sorter' => [], 'filter' => [], 'grouper' => []];
$link_parts = explode('page/', $_REQUEST['url']);
if (!empty($link_parts[1])) {
    $state['pager']['current'] = (int)$link_parts[1] - 1;
    if ($state['pager']['current'] == 0)
        header("location: /{$shop_catalog}/" . $link_parts[0]);
}


$Res = $Catalog->getList($state['filter'], $state['pager']);

$state['pager']['filtered'] = $state['pager']['total'] = $Res['pager']['filtered'];


$tpl->load_template('/smshop/catalog/shortstory.tpl');

foreach ($Res['data'] as &$item) {

    foreach ($item as $field => $value)
        $tpl->set('{' . $field . '}', $value);

    $tpl->set('{shop_catalog}', $shop_catalog);
    $tpl->compile('items');
}

// header('Content-Type: application/json; charset=UTF-8');
// echo json_encode($Res);
// exit();

include 'navigation.php';

$tpl->load_template('/smshop/catalog/main.tpl');
$tpl->set('{shop_catalog}', $shop_catalog);
$tpl->set('{items}', $tpl->result['items']);
$tpl->set('{navigation}', $tpl->result['navigation']);
$tpl->compile('content');