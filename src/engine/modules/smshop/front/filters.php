<?php

require_once ROOT_DIR . '/engine/classes/smshop/include.php';
$Category = new Category('shop_category');
$tpl->load_template('/smshop/catalog/filters.tpl');


foreach ([1, 2, 3, 4, 5] as $category_id) {

    $Res = $Category->getList(['parent_id' => $category_id, 'active_menu' => 1], ['current' => 0, 'limit' => 100], [['field' => 'title', 'direction' => 'asc']]);
    if (!empty($Res['data'])) {
        foreach ($Res['data'] as &$category) {
            if (empty($category['alt_name']))
                $category['alt_name'] = $category['title']; //active
            $category = "<li><a href='/catalog/Цветы/{$category['alt_name']}/'>{$category['title']}</a></li>";
        }
        $tpl->set("{categories_{$category_id}}", implode('', $Res['data']));
    } else
        $tpl->set("{categories_{$category_id}}", 'Нет категорий');

}


$tpl->compile('filters');
echo $tpl->result['filters'];