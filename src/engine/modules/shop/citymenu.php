<?php




$rows = $db->super_query("SELECT * FROM dle_city", true);

$columns = [];

foreach ($rows as $item) {
    $columns[] = <<<HTML
<li class="menu-item"><a href="/city-{$item['alt_name']}/">{$item['city_im']}</a></li>
HTML;
}

$numberOfColumns = 4;
$itemsPerColumn = ceil(count($columns) / $numberOfColumns);
$columnChunks = array_chunk($columns, $itemsPerColumn);

foreach ($columnChunks as $columnItems) {
    $columnHtml = implode('', $columnItems);
    echo <<<HTML
<li class="mega-dropdown-col" style="line-height: 10px"><ul>{$columnHtml}</ul></li>
HTML;
}

