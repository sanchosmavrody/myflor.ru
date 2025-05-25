<?php

$link_parts = explode('/', $_REQUEST['url']);


$order_id = 0;
if (!empty($link_parts[0]) and is_numeric($link_parts[0]))
    $order_id = (int)$link_parts[0];

if (!$order_id)
    $tpl->load_template('/smshop/order/main.tpl');
else {
    $tpl->load_template('/smshop/order/success.tpl');

    $tpl->set('{order_id}', $order_id);
}

$tpl->set('{shop_catalog}', 'shop_catalog');
$tpl->compile('content');