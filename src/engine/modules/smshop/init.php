<?php
require_once ROOT_DIR . '/engine/classes/smshop/include.php';

$shop_catalog = $_REQUEST['shop_catalog'];
$Catalog = new Catalog('shop_' . $shop_catalog);

$link_parts = explode('id/', $_REQUEST['url']);
if (!empty($link_parts[1])) {
    $Res = $Catalog->getItem((int)$link_parts[1]);

    $tpl->load_template('/smshop/catalog/fullstory.tpl');

    $Res['item']['photos'] = explode(',', $Res['item']['photos']);
    foreach ($Res['item']['photos'] as &$photo)
        $photo = <<<HTML
<div class="item"><img src="{$photo}" alt="image"></div>
HTML;
    $Res['item']['photos'] = implode('', $Res['item']['photos']);

    foreach ($Res['item'] as $field => $value)
        $tpl->set('{' . $field . '}', $value);

    $tpl->set('{shop_catalog}', $shop_catalog);
    $tpl->compile('content');

} else {

    $state = ['pager' => ['current' => 0, 'limit' => 20], 'sorter' => [], 'filter' => [], 'grouper' => []];
    $link_parts = explode('page/', $_REQUEST['url']);
    if (!empty($link_parts[1])) {
        $state['pager']['current'] = (int)$link_parts[1] - 1;
        if ($state['pager']['current'] == 0)
            header("location: /{$shop_catalog}/" . $link_parts[0]);
    }


    $Res = $Catalog->getList($state['filter'], $state['pager']);

    $state['pager']['filtered'] = $state['pager']['total'] = $Res['pager']['filtered'];

//    header('Content-Type: application/json; charset=UTF-8');
//    echo json_encode($Res);
//    exit();

    $tpl->load_template('/smshop/catalog/shortstory.tpl');

    foreach ($Res['data'] as $item) {
        $item['photos'] = explode(',', $item['photos']);
        $item['photo_main'] = empty($item['photos'][0]) ? '/templates/Full/images/catalog_auto_no_photo.png' : $item['photos'][0];

        foreach ($item as $field => $value)
            $tpl->set('{' . $field . '}', $value);

        $tpl->set('{shop_catalog}', $shop_catalog);
        $tpl->compile('items');
    }

    include 'navigation.php';

    $tpl->load_template('/smshop/catalog/main.tpl');
    $tpl->set('{shop_catalog}', $shop_catalog);
    $tpl->set('{items}', $tpl->result['items']);
    $tpl->set('{navigation}', $tpl->result['navigation']);
    $tpl->compile('content');
}