<?php
require_once ROOT_DIR . '/engine/classes/smshop/include.php';

$shop_catalog = $_REQUEST['shop_catalog'];


if ($shop_catalog == 'order')
    include 'order.php';
else if ($shop_catalog == 'basket') {
    include 'basket.php';
} else {

    $link_parts = explode('id/', $_REQUEST['url']);
    if (!empty($link_parts[1])) {
        $item_id = (int)$link_parts[1];
        include 'fullstory.php';
    } else
        include 'catalog.php';
}