<?php


if ($_REQUEST['act'] == 'parseCatsFromPrice') {

    $cat_info = $db->super_query("SELECT * FROM dle_category WHERE 1=1", true);

    $cats_by_name = [];
    $cats_by_parent = [];
    foreach ($cat_info as $cat) {
        $cats_by_name[$cat['name']] = $cat;
        $cats_by_parent[$cat['parentid']][] = $cat;
    }


    $rows = $db->super_query("SELECT DISTINCT chapter, subsection FROM store_price WHERE chapter!='' OR subsection!='' ORDER BY chapter,subsection", true);

    $res = [];
    foreach ($rows as $row) {

        $parentid = 1;
        if (false)
            $parentid = 439;

        if (empty($cats_by_name[$row['chapter']])) {
            $alt_name = totranslit($row['chapter']);
            $res[] = $row['chapter'];
            $db->query("INSERT INTO `dle_category` (`id`, `parentid`, `posi`, `name`, `alt_name`, `icon`, `skin`, `descr`, `keywords`, `news_sort`, `news_msort`, `news_number`, `short_tpl`, `full_tpl`, `metatitle`, `show_sub`, `allow_rss`, `fulldescr`, `disable_search`, `disable_main`, `disable_rating`, `disable_comments`, `enable_dzen`, `enable_turbo`, `active`, `rating_type`, `schema_org`)
VALUES (NULL, '{$parentid}', '1', '{$row['chapter']}', '{$alt_name}', '', '', '', '', '', '', '0', '', '', '', '0', '1', '', '0', '0', '0', '0', '1', '1', '1', '-1', '1')");
            $chapter_id = $db->insert_id();
            $cats_by_name[$row['chapter']] = ['id' => $chapter_id];
        } else
            $chapter_id = $cats_by_name[$row['chapter']]['id'];

        if (!empty($row['subsection']) and empty($cats_by_name[$row['subsection']])) {
            $alt_name = totranslit($row['subsection']);
            $res[] = '|__' . $row['subsection'];

            $subsection_id = $db->insert_id();
            $cats_by_name[$row['subsection']] = ['id' => $subsection_id];
            $db->query("INSERT INTO `dle_category` (`id`, `parentid`, `posi`, `name`, `alt_name`, `icon`, `skin`, `descr`, `keywords`, `news_sort`, `news_msort`, `news_number`, `short_tpl`, `full_tpl`, `metatitle`, `show_sub`, `allow_rss`, `fulldescr`, `disable_search`, `disable_main`, `disable_rating`, `disable_comments`, `enable_dzen`, `enable_turbo`, `active`, `rating_type`, `schema_org`)
VALUES (NULL, '{$chapter_id}', '1', '{$row['subsection']}', '{$alt_name}', '', '', '', '', '', '', '0', '', '', '', '0', '1', '', '0', '0', '0', '0', '1', '1', '1', '-1', '1')");
        }
    }


    echo '<pre>';
    var_export($res);
    echo '</pre>';
    exit();
}


//https://elephant-flowers.ru/engine/ajax/shop/index.php?mod=catalog&act=search_catalog
if ($_REQUEST['act'] == 'search_catalog') {

    $search_text = $db->safesql(trim($_REQUEST['search_text']));

    $rows = [];
    if (!empty($search_text) and strlen($search_text) > 3) {
        $WHERE = " AND (name LIKE '%{$search_text}%' )"; // OR chapter LIKE '%{$search_text}%' OR subsection LIKE '%{$search_text}%'
        $cstart = 1;
        $limit = 300;

        $rows = $db->super_query("
                    SELECT 
                        code,
                        img,
                        name,
                        price,                       
                         SUM(amount) as amount,
                        availability,
                        store,
                        chapter,
                        subsection,
                        invoice
                    FROM store_price 
                    WHERE 1=1 {$WHERE} 
                    GROUP BY `code`  
                    LIMIT {$cstart},{$limit}
", true);

        foreach ($rows as &$row) {
            $row['name'] = str_replace([
                ', 1 партия',
                ', 2 партия',
                ', 3 партия',
                ', 4 партия',
                ', 5 партия',
                ', 6 партия',
                ', 8 партия',
                ', 9 партия',
                ', 10 партия',
                ', 11 партия',
                ', 12 партия'
            ], '', $row['name']);
        }
    }

    $Res['data'] = $rows;
}
