<?php

global $shop_catalog, $item_id;
$Catalog = new Catalog('shop_' . $shop_catalog);
$Res = $Catalog->getItem($item_id);

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