<?php


$main_table = $_REQUEST['mod'];

if ($_REQUEST['act'] == 'settings') {

    $table_fields = DbHelper::load_table_fields($main_table);

    $fields_form = [];
    $fields_grid = [];
    foreach ($table_fields as $table_field) {
        if ($table_field !== 'id')
            $fields_form[] = ["name"        => $table_field, "field" => $table_field, "type" => "text",
                              "layout_type" => "floating",];
        $fields_grid[] = ["name" => $table_field, "field" => $table_field];
    }


    $Res = [
        "stats"    => [],
        "informer" => [
//            [
//                "text"        => <<<HTML
//       Обратите внимание!
//        <ul style="list-style:auto">
//            <li>Все будет хорошо</li>
//        </ul>
//HTML
//                ,
//                "id"          => "sites_info",
//                "type"        => "warning",
//                "allow_close" => true
//            ]
        ],
        "form"     => [
            "type"   => "modal", // modal row page
            "fields" => $fields_form,
        ],
        "grid"     => [
            "id"      => 'id',
            "columns" => $fields_grid,
            "sorter"  => [
                [
                    "field"     => "id",
                    "direction" => "desc"
                ]
            ],
            "pager"   => [
                "current" => 0,
                "total"   => 0,
                "limit"   => 25,

            ],
            "filters" => [
                [
                    "title"        => "Поиск",
                    "type"         => "input",
                    "target_field" => "search_query",
                    "css_class"    => "col-4"
                ],
            ]
        ],
        "module"   => ['name' => $main_table, 'title' => $main_table,],
        "api_url"  => "/api/v2/index.php?mod="
    ];
}

function getData($req)
{
    global $main_table;

    $sql_ORDER = 'ORDER BY id DESC';
    $sql_WHERE = [];
    $LIMIT = 100;
    $sql_JOIN = [];

    ReqHelper::applyPager($req['pager'], $LIMIT);
    if (!empty($req['sorter']))
        ReqHelper::applySorter($req['sorter'], $sql_ORDER);

    if (isset($req['filter']))
        ReqHelper::applyFilter([
            'id' => ["where" => "id = '{value}'"],
        ], $req['filter'], $sql_WHERE, $sql_JOIN);


    if (!empty($sql_WHERE))
        $sql_WHERE = ' WHERE ' . implode(' AND ', $sql_WHERE);
    else $sql_WHERE = '';
    if (!empty($sql_JOIN))
        $sql_JOIN = ' WHERE ' . implode(' AND ', $sql_JOIN);
    else $sql_JOIN = '';

    $sql_FROM = "FROM {$main_table}  {$sql_JOIN}";

    $Res['pager'] = DbHelper::get_row("SELECT (SELECT COUNT({$main_table}.id) as total {$sql_FROM}) as total, (SELECT COUNT({$main_table}.id) as filtered {$sql_FROM} {$sql_WHERE}) as filtered");
    $Res['pager']['current'] = $req['pager']['current'];
    $Res['pager']['limit'] = $req['pager']['limit'];
    $Res['totals'] = false;

    $Res['data'] = [];
    if (!empty($Res['pager']['filtered'])) {
        $Res['data'] = DbHelper::get("SELECT {$main_table}.* {$sql_FROM} {$sql_WHERE} {$sql_ORDER} LIMIT {$LIMIT}");
        // foreach ($Res['data'] as &$row)
    }

    return $Res;
}

if ($_REQUEST['act'] === 'data') {

    if (!empty($req)) {
        $current = 0;
        if (!empty($req['pager']['current']))
            $current = $req['pager']['current'];
        $Res = getData($req);
        //foreach ($Res['data'] as &$row){
        //
        //}
    }
}

if ($_REQUEST['act'] === 'item') {

    $Res = getData(['filter' => ['id' => (int)$req['id']], 'pager' => ['current' => 0, 'limit' => 1]]);
    $object_fields = array_keys($Res['data'][0]);
    $fields_form = [];
    foreach ($object_fields as $table_field)
        $fields_form[] = [
            "name"        => $table_field,
            "field"       => $table_field,
            "type"        => "text",
            "layout_type" => "floating",
        ];
    $Res = [
        'data' => [
            'item'          => $Res['data'][0],
            'item_settings' => [
                "allow_delete" => true,
                "allow_save"   => true,
                "fields"       => $fields_form,
                "type"         => "modal"
            ]
        ]
    ];
}

if ($_REQUEST['act'] == 'save') {
    $Res = [];
    if (!empty($req)) {
        if (empty($req['id']))
            $Res = DbHelper::add($main_table, $req);
        else
            $Res = DbHelper::update($main_table, $req, "id='{$req['id']}'");
    }
}
