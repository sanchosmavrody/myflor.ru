<?php
$Basket = new Basket('shop_basket');
if($_REQUEST['act'] == 'get') {

}
if ($_REQUEST['act'] == 'add' OR $_REQUEST['act'] == 'remove') {


    $WHERE = '';
    if (!empty($req['search']))
        $WHERE = "WHERE name LIKE '%{$req['search']}%'";


    $filter = $sorter = $params = [];
    $filter['title'] = '';


    $filter['parent_id'] = $_REQUEST['parent_id'];

    $Res = $Basket->getAsOptions($filter, ['current' => 0, 'limit' => 100],
        $sorter, ['name' => 'title', 'value' => 'id']);
}
