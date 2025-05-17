<?php

require_once ROOT_DIR . '/engine/classes/smshop/include.php';

if (!empty($parent_id)) {
    $parent_id = (int)$parent_id;
    $Category = new Category('shop_category');
    $parent_category = $Category->getItem($parent_id)['item'];
    $Res = $Category->getList(['parent_id' => $parent_id, 'active_menu' => 1], [0, 100], [['field' => 'title', 'direction' => 'asc']]);

    $echo = [];
    $count_per_col = $col = 1;
    if (!empty($cols)) {
        $count_per_col = ceil($Res['pager']['filtered'] / $cols);
    }
    foreach ($Res['data'] as $row_i => $category) {


        if (empty($parent_category['alt_name']))
            $parent_category['alt_name'] = $parent_category['title'];

        if (empty($category['alt_name']))
            $category['alt_name'] = $category['title'];
        if (empty($cols))
            $echo[] = <<<HTML
    <li class="nav-item">
        <a href="/catalog/{$parent_category['alt_name']}/{$category['alt_name']}/" class="nav-link">{$category['title']}</a>
    </li>              
HTML;
        else {

            if (!empty($echo[$col]) and $count_per_col == count($echo[$col]))
                $col++;
            $echo[$col][] = <<<HTML
    <li><a href="/catalog/{$parent_category['alt_name']}/{$category['alt_name']}/">{$category['title']}</a></li>              
HTML;
        }
    }
    if (empty($cols))
        echo implode('', $echo);
    else {
        foreach ($echo as $col => $items) {
            $items = implode('', $items);
            echo <<<HTML
        <div class="col">
            <ul class="megamenu-submenu">
              {$items}
            </ul>
        </div>
HTML;
        }
    }

}

//echo $parent_id;