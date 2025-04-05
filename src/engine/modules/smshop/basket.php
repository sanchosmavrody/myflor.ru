<?php

$Basket = new Basket('shop_basket');

$state = ['pager' => ['current' => 0, 'limit' => 100], 'sorter' => [], 'filter' => [], 'grouper' => []];

$Res = $Basket->getList($state['filter'], $state['pager']);

$state['pager']['filtered'] = $state['pager']['total'] = $Res['pager']['filtered'];


$tpl->load_template('/smshop/basket/shortstory.tpl');

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

$tpl->load_template('/smshop/basket/main.tpl');
$tpl->set('{shop_catalog}', $shop_catalog);
$tpl->set('{items}', $tpl->result['items']);
$tpl->set('{navigation}', $tpl->result['navigation']);
$tpl->compile('content');