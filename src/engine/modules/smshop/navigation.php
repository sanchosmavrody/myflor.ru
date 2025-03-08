<?php


$per_page = $state['pager']['limit'];
$cstart = $state['pager']['current'] * $per_page;
$news_count = $cstart + count($Res['data']);

$url_page = '/catalog';
$tpl->load_template('navigation.tpl');

//----------------------------------
// Previous link
//----------------------------------

$no_prev = false;
$no_next = false;

if (isset($cstart) and $cstart != "" and $cstart > 0) {
    $prev = $cstart / $per_page;

    if ($prev == 1)
        $prev_page = $url_page . "/";
    else
        $prev_page = $url_page . "/page/" . $prev . "/";

    $tpl->set_block("'\[prev-link\](.*?)\[/prev-link\]'si", "<li><a class='page-numbers' href=\"" . $prev_page . "\">\\1</a></li>");

} else {
    $tpl->set_block("'\[prev-link\](.*?)\[/prev-link\]'si", "");
    $no_prev = TRUE;
}

//----------------------------------
// Pages
//----------------------------------
if ($per_page) {

    $pages = [];

    if ($state['pager']['filtered'] > $per_page) {
        $enpages_count = @ceil($state['pager']['filtered'] / $per_page);
        $cstart = ($cstart / $per_page) + 1;
        $max_pages = 10;
        if ($enpages_count <= $max_pages) {
            for ($j = 1; $j <= $enpages_count; $j++) {
                if ($j != $cstart) {

                    if ($j == 1)
                        $pages[] = "<a class='page-numbers' href=\"" . $url_page . "/\">$j</a> ";
                    else
                        $pages[] = "<a class='page-numbers' href=\"" . $url_page . "/page/" . $j . "/\">$j</a> ";

                } else
                    $pages[] = "<span class='page-numbers current'>$j</span>";
            }
        } else {
            $nav_prefix = "<span class='page-numbers dots'>…</span>  ";
            $start = 1;
            $end = 10;

            if ($cstart > 6) {
                $start = $cstart - 4;
                $end = $start + 8;
                if ($end >= $enpages_count - 1) {
                    $start = $enpages_count - 9;
                    $end = $enpages_count - 1;
                }
            }

            if ($end >= $enpages_count - 1)
                $nav_prefix = "";
            else
                $nav_prefix = "<span class='page-numbers dots'>…</span> ";

            if ($start >= 2) {
                if ($start >= 3)
                    $before_prefix = "<span class='page-numbers dots'>…</span> ";
                else $before_prefix = "";
                $pages[] = "<a class='page-numbers' href=\"" . $url_page . "/\">1</a> " . $before_prefix;
            }

            for ($j = $start; $j <= $end; $j++) {
                if ($j != $cstart) {
                    if ($j == 1)
                        $pages[] = "<a class='page-numbers' href=\"" . $url_page . "/\">$j</a> ";
                    else
                        $pages[] = "<a class='page-numbers' href=\"" . $url_page . "/page/" . $j . "/\">$j</a> ";
                } else
                    $pages[] = "<span class='page-numbers current'>$j</span>";
            }

            if ($cstart != $enpages_count)
                $pages[] = $nav_prefix . "<a class='page-numbers' href=\"" . $url_page . "/page/{$enpages_count}/\">{$enpages_count}</a>";
            else
                $pages[] = "<span class='page-numbers current'>{$enpages_count}</span> ";
        }
    }

    foreach ($pages as &$page)
        $page = "<li>{$page}</li>";


    $tpl->set('{pages}', implode($pages));

}

//----------------------------------
// Next link
//----------------------------------


if ($per_page and $per_page < $state['pager']['filtered'] and $news_count < $state['pager']['filtered']) {
    $next_page = ($news_count) / $per_page + 1;

    $next = $url_page . '/page/' . $next_page . '/';
    $tpl->set_block("'\[next-link\](.*?)\[/next-link\]'si", "<li><a class='page-numbers' href=\"" . $next . "\">\\1</a></li>");

} else {
    $tpl->set_block("'\[next-link\](.*?)\[/next-link\]'si", "");
    $no_next = TRUE;
}


$tpl->compile('navigation');
$tpl->clear();

