<?php

require_once ROOT_DIR . '/engine/classes/smshop/include.php';

if (!empty($parent_id)) {
    $parent_id = (int)$parent_id;
    $Category = new Category('shop_category');
    $parent_category = $Category->getItem($parent_id)['item'];
    $Res = $Category->getList(['parent_id' => $parent_id], [0, 100]);

    $echo = [];
    foreach ($Res['data'] as $category) {
        if (empty($parent_category['alt_name']))
            $parent_category['alt_name'] = $parent_category['title'];

        if (empty($category['alt_name']))
            $category['alt_name'] = $category['title'];

        $echo[] = <<<HTML
    <li class="nav-item">
        <a href="/catalog/{$parent_category['alt_name']}/{$category['alt_name']}/" class="nav-link">{$category['title']}</a>
    </li>              
HTML;

        echo implode('', $echo);
    }
}

echo $parent_id;