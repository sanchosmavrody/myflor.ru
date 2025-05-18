<?php

global $shop_catalog, $item_id;
$Catalog = new Catalog('shop_' . $shop_catalog);
$Category = new Catalog('shop_category');
$Res = $Catalog->getItem($item_id);

$tpl->load_template('/smshop/catalog/fullstory.tpl');

foreach ($Res['item']['photos'] as &$photo)
    $photo = <<<HTML
<div class="item"><img src="{$photo}" alt="image"></div>
HTML;
$Res['item']['photos'] = implode('', $Res['item']['photos']);

foreach ([1, 3, 4, 5] as $category_id)
    if ($Res['item']['category_' . $category_id]) {
        $Res['item']['category_' . $category_id] = explode(',', $Res['item']['category_' . $category_id]);
        foreach ($Res['item']['category_' . $category_id] as &$category_item) {
            $category = $Category->getItem($category_item);
            $category['item']['alt_name'] = $category['item']['alt_name'] ? $category['item']['alt_name'] : $category['item']['title'];
            $category_item = '<a href="' . $category['item']['alt_name'] . '">' . $category['item']['title'] . '</a>';
        }
        $Res['item']['category_' . $category_id . '_name'] = implode(', ', $Res['item']['category_' . $category_id]);
    }

foreach ($Res['item'] as $field => $value)
    $tpl->set('{' . $field . '}', $value);

$tpl->set('{shop_catalog}', $shop_catalog);
$tpl->compile('content');