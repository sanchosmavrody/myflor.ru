<?php

if ($_REQUEST['act'] == 'category') {
    $WHERE = '';
    if (!empty($req['search']))
        $WHERE = "WHERE name LIKE '%{$req['search']}%'";

    $Catalog = new Category('shop_category');
    $filter = $sorter = $params = [];
    $filter['title'] = '';
    $Res = $Catalog->getAsOptions($filter, ['current' => 0, 'limit' => 100], $sorter, ['name' => 'title', 'value' => 'id']);
}

if ($_REQUEST['act'] == 'composition') {
    $Res = [];
    $filter = $sorter = $params = [];
    $Composition = new Composition('shop_composition');
    if (!empty($req['search']))
        $filter['search_query'] = $req['search'];
    elseif (!empty($req['form']['composition_id']))
        $filter['id'] = $req['form']['composition_id'];

    $Res = $Composition->getAsOptions($filter, ['current' => 0, 'limit' => 15], $sorter, ['name' => 'title', 'value' => 'id']);
}


if ($_REQUEST['act'] == 'load') {

    function convert_rows_to_list(&$rows, $field_value, $field_name)
    {
        $res = [];
        foreach ($rows as $row)
            $res[] = ['value' => $row[$field_value], 'name' => $row[$field_name]];

        return $res;
    }

    $req_body = file_get_contents('php://input');
    $REQ = json_decode($req_body, true);

    $state_lists = [];
    $sql_state_filters = [
        'mark'         => "mark.id ='{$REQ['state']['mark']}'",
        'model'        => "model.id ='{$REQ['state']['model']}'",
        'generation'   => "generation.id ='{$REQ['state']['generation']}'",
        'body'         => "configuration.`body-type` ='{$REQ['state']['body']}'",
        'transmission' => "SP_transmission.transmission ='{$REQ['state']['transmission']}'",
        'engine'       => "SP_engine.`engine-type` ='{$REQ['state']['engine']}'",
        'drive'        => "SP_drive.drive ='{$REQ['state']['drive']}'",
    ];

    $WHERE = [1];

    foreach ($REQ['state'] as $filter_name => $value) {
        $state_lists[$filter_name] = ['list' => [['value' => '', 'name' => 'Выберите']]];

        if (!empty($value))
            $WHERE[$filter_name] = $sql_state_filters[$filter_name];
    }


    $sql_BODY = <<<SQL
FROM modification 
    JOIN configuration ON configuration.id = modification.configuration_id 
    JOIN generation ON generation.id = configuration.generation_id 
    JOIN model ON model.id = generation.model_id 
    JOIN mark ON mark.id = model.mark_id

JOIN specifications as SP_transmission ON SP_transmission.complectation_id = modification.`complectation-id` 
JOIN specifications as SP_engine ON SP_engine.complectation_id = modification.`complectation-id` 
JOIN specifications as SP_drive ON SP_drive.complectation_id = modification.`complectation-id` 

SQL;


    function get_sql_where($filter_name, $WHERE)
    {
        foreach ($filter_name as $item)
            unset($WHERE[$item]);
        $WHERE = array_values($WHERE);
        return implode(' AND ', $WHERE);
    }

    //$WHERE=  get_sql_where('mark',$WHERE);
    //  $Res['get_sql_where'] = $WHERE;


    $rows = $db->super_query("SELECT DISTINCT mark.id, mark.name {$sql_BODY} WHERE " . get_sql_where(['mark', 'model', 'generation'], $WHERE) . "  ORDER BY mark.name", true);
    $state_lists['mark']['list'] = array_merge($state_lists['mark']['list'], convert_rows_to_list($rows, 'id', 'name'));

    if (!empty($REQ['state']['mark'])) {
        $rows = $db->super_query("SELECT DISTINCT model.id, model.name {$sql_BODY} WHERE " . get_sql_where(['model', 'generation'], $WHERE) . " ORDER BY model.name", true);
        if (!empty($rows))
            $state_lists['model']['list'] = array_merge($state_lists['model']['list'], convert_rows_to_list($rows, 'id', 'name'));
    }

    if (!empty($REQ['state']['model'])) {
        $rows = $db->super_query("SELECT DISTINCT generation.id, generation.name {$sql_BODY} WHERE " . get_sql_where('generation', $WHERE) . "  ORDER BY generation.name", true);
        if (!empty($rows))
            $state_lists['generation']['list'] = array_merge($state_lists['generation']['list'], convert_rows_to_list($rows, 'id', 'name'));
    }


    $rows = $db->super_query("SELECT DISTINCT configuration.`body-type` as id, configuration.`body-type` as name {$sql_BODY} WHERE   " . get_sql_where(['body'], $WHERE), true);
    $state_lists['body']['list'] = array_merge($state_lists['body']['list'], convert_rows_to_list($rows, 'id', 'name'));

    $rows = $db->super_query("SELECT DISTINCT SP_transmission.transmission as id, SP_transmission.transmission as name {$sql_BODY} WHERE   " . get_sql_where(['transmission'], $WHERE), true);
    $state_lists['transmission']['list'] = array_merge($state_lists['transmission']['list'], convert_rows_to_list($rows, 'id', 'name'));

    $rows = $db->super_query("SELECT DISTINCT SP_engine.`engine-type` as id, SP_engine.`engine-type` as name {$sql_BODY} WHERE   " . get_sql_where(['engine'], $WHERE), true);
    $state_lists['engine']['list'] = array_merge($state_lists['engine']['list'], convert_rows_to_list($rows, 'id', 'name'));

    $rows = $db->super_query("SELECT DISTINCT SP_drive.drive as id, SP_drive.drive as name {$sql_BODY} WHERE   " . get_sql_where(['engine'], $WHERE), true);
    $state_lists['drive']['list'] = array_merge($state_lists['drive']['list'], convert_rows_to_list($rows, 'id', 'name'));


    $Res = [
        'body'          => "SELECT DISTINCT mark.id, mark.name {$sql_BODY} WHERE " . get_sql_where(['mark', 'model', 'generation'], $WHERE) . "  ORDER BY mark.name",
        'state'         => $REQ['state'],
        'change_filter' => $REQ['change_filter'],
        'state_lists'   => $state_lists
    ];

}