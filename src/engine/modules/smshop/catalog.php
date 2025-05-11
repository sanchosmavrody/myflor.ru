<?php
global $shop_catalog;
$Catalog = new Catalog('shop_' . $shop_catalog);

$state = ['pager' => ['current' => 0, 'limit' => 20], 'sorter' => [], 'filter' => [], 'grouper' => []];
$url = $_REQUEST['url'];

#### Вытаскиваем пейджилку
$link_parts = explode('page/', $url);
if (!empty($link_parts[1])) {//костыль на пейджилку, если первая страница убираем /page/
    $state['pager']['current'] = (int)$link_parts[1] - 1;
    if ($state['pager']['current'] == 0)
        header("location: /{$shop_catalog}/" . $link_parts[0].'/');
}

$params = explode('?', $_SERVER['REQUEST_URI']);
if(!empty($params[1]))
    parse_str($params[1], $state['filter']);
#### Вытаскиваем урл категории
//substr($str,-1)
if(substr($link_parts[0],-1) == '/')
    $link_parts[0] = mb_substr($link_parts[0], 0, -1);
$link_parts = explode('/', $link_parts[0]);//все кроме секции page/+
$cat_filters=[];
if(!empty(end($link_parts)))
    $cat_filters['title'] = end($link_parts);
$Category = new Category('shop_category');
$categories = $Category->getList($cat_filters,['current' => 0, 'limit' => 20]);
$page_category = $categories['data'][0];

if($link_parts[0]=='Цветы' and !empty($link_parts[1]) )
    $state['filter']['category_1'] = $page_category['id'];

$Res = $Catalog->getList($state['filter'], $state['pager']);
$state['pager']['filtered'] = $state['pager']['total'] = $Res['pager']['filtered'];


$tpl->load_template('/smshop/catalog/shortstory.tpl');

foreach ($Res['data'] as &$item) {
    unset($item['photos']);

    foreach ($item as $field => $value)
        $tpl->set('{' . $field . '}', $value);

    $tpl->set('{shop_catalog}', $shop_catalog);
    $tpl->compile('items');
}

 //header('Content-Type: application/json; charset=UTF-8');
 //echo json_encode($Res);
 //exit();

include 'navigation.php';

$tpl->load_template('/smshop/catalog/main.tpl');
$tpl->set('{shop_catalog}', $shop_catalog);
$tpl->set('{items}', $tpl->result['items']);
$tpl->set('{navigation}', $tpl->result['navigation']);
$tpl->compile('content');