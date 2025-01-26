<?php
/*
=====================================================
 DataLife Engine - by SoftNews Media Group
-----------------------------------------------------
 https://dle-news.ru/
-----------------------------------------------------
 Copyright (c) 2004-2023 SoftNews Media Group
=====================================================
 This code is protected by copyright
=====================================================
 File: show.short.php
-----------------------------------------------------
 Use:  view short news
=====================================================
*/

if (!defined('DATALIFEENGINE')) {
    header("HTTP/1.1 403 Forbidden");
    header('Location: ../../');
    die("Hacking attempt!");
}

//echo "{$join_category} {$extra_join} WHERE {$where_category}<br>";
//
//$get_cats = str_replace ( "|", "','", get_sub_cats($category_id) );
//echo get_sub_cats($get_cats);
//echo get($get_cats);
//
//exit();
if ($allow_active_news) {

    $news_count = $cstart;
    $global_news_count = 0;
    $news_found = false;
    $tpl->news_mode = true;
    $page_description = "";


    $cat_info_by_alt_name = [];
    foreach ($cat_info as $item)
        $cat_info_by_alt_name[$item['alt_name']] = $item['name'];

    if ($category_id and $cat_info[$category_id]['short_tpl'] != '')
        $tpl->load_template($cat_info[$category_id]['short_tpl'] . '.tpl');
    else
        $tpl->load_template('pages/price_row.tpl');

    $WHERE = '';
    $cats_list = explode('/', $_GET['category']);

    if (!empty($cats_list[1]))
        $WHERE .= " AND chapter = '" . $cat_info_by_alt_name[$db->safesql($cats_list[1])] . "' ";
    if (!empty($cats_list[2]))
        $WHERE .= " AND subsection = '" . $cat_info_by_alt_name[$db->safesql($cats_list[2])] . "' ";

    $sql_result = $db->query("
SELECT 
    code,
    img,
    name,
    price,
   -- amount,
     SUM(amount) as amount,
    availability,
    store,
    chapter,
    subsection,
    invoice
FROM store_price 
WHERE 1=1 {$WHERE} 
GROUP BY `code`  
 LIMIT {$cstart},{$config['news_number']}
");

    while ($row = $db->get_row($sql_result)) {
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
        $news_found = TRUE;
        foreach ($row as $field => $value)
            $tpl->set('{' . $field . '}', str_replace("&amp;amp;", "&amp;", htmlspecialchars($row[$field], ENT_QUOTES, $config['charset'])));
        $tpl->compile('content', true, false);
    }

    $tpl->news_mode = false;
    $tpl->clear();
    $db->free($sql_result);

    if ($news_found and !$view_template) {
        $count_all = $db->super_query("SELECT count(DISTINCT `code`) as cnt FROM store_price WHERE 1=1 {$WHERE} ");
        $count_all = $count_all['cnt'];

    } else $count_all = 0;

    if (!$news_found and $allow_userinfo and $member_id['name'] == $user and $user_group[$member_id['user_group']]['allow_adds']) {

        $tpl->load_template('info.tpl');
        $tpl->set('{error}', $lang['mod_list_f']);
        $tpl->set('{title}', $lang['all_info']);
        $tpl->compile('content');
        $tpl->clear();

    } elseif (!$news_found and $do == 'newposts' and $view_template != 'rss') {
        msgbox($lang['all_info'], $lang['newpost_notfound']);
    }

    if (!$view_template and $count_all and $config['news_navigation']) {

        $tpl->load_template('navigation.tpl');

        //----------------------------------
        // Previous link
        //----------------------------------


        $no_prev = false;
        $no_next = false;

        if (isset($cstart) and $cstart != "" and $cstart > 0) {
            $prev = $cstart / $config['news_number'];

            if ($config['allow_alt_url']) {

                if ($prev == 1)
                    $prev_page = $url_page . "/";
                else
                    $prev_page = $url_page . "/page/" . $prev . "/";

                $tpl->set_block("'\[prev-link\](.*?)\[/prev-link\]'si", "<a href=\"" . $prev_page . "\">\\1</a>");

            } else {

                if ($prev == 1) {

                    if ($user_query) $prev_page = $PHP_SELF . "?" . $user_query;
                    else $prev_page = $config['http_home_url'];

                } else {

                    if ($user_query) $prev_page = $PHP_SELF . "?cstart=" . $prev . "&amp;" . $user_query;
                    else $prev_page = $PHP_SELF . "?cstart=" . $prev;
                }

                $tpl->set_block("'\[prev-link\](.*?)\[/prev-link\]'si", "<a href=\"" . $prev_page . "\">\\1</a>");
            }

        } else {
            $tpl->set_block("'\[prev-link\](.*?)\[/prev-link\]'si", "<span>\\1</span>");
            $no_prev = TRUE;
        }

        //----------------------------------
        // Pages
        //----------------------------------
        if ($config['news_number']) {

            $pages = "";

            if ($count_all > $config['news_number']) {

                $enpages_count = @ceil($count_all / $config['news_number']);

                $cstart = ($cstart / $config['news_number']) + 1;

                $max_pages = 10;

                if ($enpages_count <= $max_pages) {

                    for ($j = 1; $j <= $enpages_count; $j++) {

                        if ($j != $cstart) {

                            if ($config['allow_alt_url']) {

                                if ($j == 1)
                                    $pages .= "<a href=\"" . $url_page . "/\">$j</a> ";
                                else
                                    $pages .= "<a href=\"" . $url_page . "/page/" . $j . "/\">$j</a> ";

                            } else {

                                if ($j == 1) {

                                    if ($user_query) {
                                        $pages .= "<a href=\"{$PHP_SELF}?{$user_query}\">$j</a> ";
                                    } else $pages .= "<a href=\"{$config['http_home_url']}\">$j</a> ";

                                } else {

                                    if ($user_query) {
                                        $pages .= "<a href=\"$PHP_SELF?cstart=$j&amp;$user_query\">$j</a> ";
                                    } else $pages .= "<a href=\"$PHP_SELF?cstart=$j\">$j</a> ";

                                }

                            }

                        } else {

                            $pages .= "<span>$j</span> ";

                        }

                    }

                } else {

                    $nav_prefix = "<span class=\"nav_ext\">{$lang['nav_trennen']}</span> ";

                    $start = 1;
                    $end = 10;

                    if ($cstart > 0) {

                        if ($cstart > 6) {

                            $start = $cstart - 4;
                            $end = $start + 8;

                            if ($end >= $enpages_count - 1) {
                                $start = $enpages_count - 9;
                                $end = $enpages_count - 1;
                            }
                        }
                    }

                    if ($end >= $enpages_count - 1) $nav_prefix = ""; else $nav_prefix = "<span class=\"nav_ext\">{$lang['nav_trennen']}</span> ";

                    if ($start >= 2) {

                        if ($start >= 3) $before_prefix = "<span class=\"nav_ext\">{$lang['nav_trennen']}</span> "; else $before_prefix = "";

                        if ($config['allow_alt_url']) $pages .= "<a href=\"" . $url_page . "/\">1</a> " . $before_prefix;
                        else {
                            if ($user_query) $pages .= "<a href=\"$PHP_SELF?{$user_query}\">1</a> " . $before_prefix;
                            else $pages .= "<a href=\"{$config['http_home_url']}\">1</a> " . $before_prefix;
                        }

                    }

                    for ($j = $start; $j <= $end; $j++) {

                        if ($j != $cstart) {

                            if ($config['allow_alt_url']) {

                                if ($j == 1)
                                    $pages .= "<a href=\"" . $url_page . "/\">$j</a> ";
                                else
                                    $pages .= "<a href=\"" . $url_page . "/page/" . $j . "/\">$j</a> ";

                            } else {

                                if ($j == 1) {

                                    if ($user_query) {
                                        $pages .= "<a href=\"{$PHP_SELF}?{$user_query}\">$j</a> ";
                                    } else $pages .= "<a href=\"{$config['http_home_url']}\">$j</a> ";

                                } else {

                                    if ($user_query) {
                                        $pages .= "<a href=\"$PHP_SELF?cstart=$j&amp;$user_query\">$j</a> ";
                                    } else $pages .= "<a href=\"$PHP_SELF?cstart=$j\">$j</a> ";

                                }

                            }

                        } else {

                            $pages .= "<span>$j</span> ";
                        }

                    }

                    if ($cstart != $enpages_count) {

                        if ($config['allow_alt_url']) {

                            $pages .= $nav_prefix . "<a href=\"" . $url_page . "/page/{$enpages_count}/\">{$enpages_count}</a>";

                        } else {

                            if ($user_query) $pages .= $nav_prefix . "<a href=\"$PHP_SELF?cstart={$enpages_count}&amp;$user_query\">{$enpages_count}</a>";
                            else $pages .= $nav_prefix . "<a href=\"$PHP_SELF?cstart={$enpages_count}\">{$enpages_count}</a>";

                        }

                    } else
                        $pages .= "<span>{$enpages_count}</span> ";

                }

            }

            $tpl->set('{pages}', $pages);

        }

        //----------------------------------
        // Next link
        //----------------------------------
        if ($config['news_number'] and $config['news_number'] < $count_all and $news_count < $count_all) {
            $next_page = $news_count / $config['news_number'] + 1;

            if ($config['allow_alt_url']) {
                $next = $url_page . '/page/' . $next_page . '/';
                $tpl->set_block("'\[next-link\](.*?)\[/next-link\]'si", "<a href=\"" . $next . "\">\\1</a>");
            } else {

                if ($user_query) $next = $PHP_SELF . "?cstart=" . $next_page . "&amp;" . $user_query;
                else $next = $PHP_SELF . "?cstart=" . $next_page;

                $tpl->set_block("'\[next-link\](.*?)\[/next-link\]'si", "<a href=\"" . $next . "\">\\1</a>");
            }

        } else {
            $tpl->set_block("'\[next-link\](.*?)\[/next-link\]'si", "<span>\\1</span>");
            $no_next = TRUE;
        }

        if (!$no_prev or !$no_next) {

            $tpl->compile('navigation');

            switch ($config['news_navigation']) {

                case "2" :

                    $tpl->result['content'] = '{newsnavigation}' . $tpl->result['content'];
                    break;

                case "3" :

                    $tpl->result['content'] = '{newsnavigation}' . $tpl->result['content'] . '{newsnavigation}';
                    break;

                default :
                    $tpl->result['content'] .= '{newsnavigation}';
                    break;

            }

        } else $tpl->result['navigation'] = "";

        $tpl->clear();

    } else $tpl->result['navigation'] = "";


}
?>
