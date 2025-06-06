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
        header("location: /{$shop_catalog}/" . $link_parts[0] . '/');
}

$params = explode('?', $_SERVER['REQUEST_URI']);
if (!empty($params[1]))
    parse_str($params[1], $state['filter']);
#### Вытаскиваем урл категории
//substr($str,-1)
if (substr($link_parts[0], -1) == '/')
    $link_parts[0] = mb_substr($link_parts[0], 0, -1);
$link_parts = explode('/', $link_parts[0]);//все кроме секции page/+
$cat_filters = [];
if (!empty(end($link_parts)))
    $cat_filters['title'] = end($link_parts);
$Category = new Category('shop_category');
$categories = $Category->getList($cat_filters, ['current' => 0, 'limit' => 20]);
$page_category = $categories['data'][0];


$Res = $Category->getList(['parent_id' => '0'], ['current' => 0, 'limit' => 100], [['field' => 'title', 'direction' => 'asc']]);
$main_categories = [];
foreach ($Res['data'] as &$category)
    $main_categories[$category['id']] = $category['title'];

if (!empty($link_parts[1]))
    foreach ($main_categories as $category_id => $main_title)
        if ($link_parts[0] == $main_title)
            $state['filter']['category_' . $category_id] = $page_category['id'];


//if (!empty($link_parts[1])) {
//    if ($link_parts[0] == 'Цветы')
//        $state['filter']['category_1'] = $page_category['id'];
//    if ($link_parts[0] == 'Тип композиции')
//        $state['filter']['category_2'] = $page_category['id'];
//    if ($link_parts[0] == 'Цвет')
//        $state['filter']['category_3'] = $page_category['id'];
//    if ($link_parts[0] == 'Повод')
//        $state['filter']['category_4'] = $page_category['id'];
//    if ($link_parts[0] == 'Кому')
//        $state['filter']['category_5'] = $page_category['id'];
//}

$Res = $Catalog->getList($state['filter'], $state['pager']);
$state['pager']['filtered'] = $state['pager']['total'] = $Res['pager']['filtered'];


$tpl->load_template('/smshop/catalog/shortstory.tpl');

foreach ($Res['data'] as &$item) {
    unset($item['photos']);

    foreach ($item as $field => $value)
        $tpl->set('{' . $field . '}', $value);

    if ($item['tag'])
        $tpl->set('{tag_html}', "<div class='sale-tag'>{$item['tag']}</div>");
    else
        $tpl->set('{tag_html}', "");


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