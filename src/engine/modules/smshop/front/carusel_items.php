<?php

require_once ROOT_DIR . '/engine/classes/smshop/include.php';
$Catalog = new Catalog('shop_catalog');
$state = [
    'pager'   => ['current' => 0, 'limit' => 20],
    'sorter'  => [],
    'filter'  => [],
    'grouper' => []
];
if (!empty($carousel_name))
    $state['filter']['main_carousel'] = $carousel_name;

$Res = $Catalog->getList($state['filter'], $state['pager']);


$tpl->load_template('/pages/main_carusel_item.tpl');

foreach ($Res['data'] as &$item) {
    unset($item['photos']);

    foreach ($item as $field => $value)
        $tpl->set('{' . $field . '}', $value);

    if ($item['tag'])
        $tpl->set('{tag_html}', "<div class='sale-tag'>{$item['tag']}</div>");
    else
        $tpl->set('{tag_html}', "");

    $tpl->set('{shop_catalog}', 'catalog');
    $tpl->compile('items');
}

echo $tpl->result['items'];