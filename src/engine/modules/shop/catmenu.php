<?php
$arrChildCatById = [];

global $now_city;

$city_alt = '';
if ($now_city['alt_name'] != 'moskva')
    $city_alt = '/city-' . $now_city['alt_name'];




$cat_info_by_name = [];
foreach ($cat_info as $item)
    $cat_info_by_name[$item['name']] = $item;
ksort($cat_info_by_name);

foreach ($cat_info_by_name as $thisCat)
    $arrChildCatById[$thisCat['parentid']][] = $thisCat;


if (!empty($big)) {

    if (!empty($arrChildCatById[$catid]))
        $limit = round(count($arrChildCatById[$catid]) / 4) + 2;
    else $limit = 1000;
    $res = [];
    $i = 1;
    $column = 1;
    foreach ($arrChildCatById[$catid] as $item) {
        if ($limit == $i) {
            $column++;
            $i = 1;
        }

        $url = get_url($item['id']);
        $res[$column][] = <<<HTML
 <li class="menu-item"><a href="{$city_alt}/{$url}/">{$item['name']}</a></li>
HTML;
        $i++;
    }

    foreach ($res as $column => $rows) {
        $rows = implode('', $rows);
        echo <<<HTML
       <li class="mega-dropdown-col" style="line-height: 10px"><ul>{$rows}</ul></li>
HTML;

    }

} else if (!empty($sidebar) and !empty($_REQUEST['category'])) {
    //Категория из первой секции урла - наш коренной каталог


    $this_cat_alt = explode('/', $_REQUEST['category']);
    $catid = get_ID($cat_info, $this_cat_alt[0]);

    $res = [];
    $echo = [];
    foreach ($arrChildCatById[$catid] as $item) {
        $url_parent = get_url($item['id']);

        $childs = [];
        foreach ($arrChildCatById[$item['id']] as $item_child) {
            $url = get_url($item_child['id']);
            $childs[] = <<<HTML
 <li class="list-group-item"><a href="{$city_alt}/{$url}/">{$item_child['name']}</a></li>
HTML;
        }
        if (!empty($childs)) {
            $childs = implode('', $childs);
            $echo[] = <<<HTML
 <li class="list-group-item ">
     <div class="d-block">
        <a href="{$city_alt}/{$url_parent}/">{$item['name']}</a>
        <div class="badge text-muted float-end" data-bs-toggle="collapse" data-bs-target=".cat_{$item['id']}" style="cursor: pointer">
          <div class="cat_{$item['id']} collapse ti-minus"></div> 
          <div class="cat_{$item['id']} collapse show ti-plus"></div> 
          
        </div>
    </div>
    <ul class="cat_{$item['id']} list-group1 list-group-flush collapse">{$childs}</ul>
</li>

HTML;
        } else
            $echo[] = <<<HTML
 <li class="list-group-item">
     <div class="d-block">
        <a href="{$city_alt}/{$url_parent}/">{$item['name']}</a>
    </div>
</li>
HTML;


    }
    $echo = implode('', $echo);
    echo <<<HTML
<ul class="list-group list-group1 list-group-flush">{$echo}</ul>
HTML;

} else
    foreach ($arrChildCatById[$catid] as $Cat) {
        $url = get_url($Cat['id']);
        echo <<<HTML
<li><a href="/{$url}/">{$Cat['name']}</a></li>
HTML;
    }









