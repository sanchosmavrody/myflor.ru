<?php
$Basket = new Basket('shop_basket');

//Во всех запросах передается UID, если он пустой генерим и на фронте положим в локал сторадж
$uid = preg_replace('/[^a-z\d]/ui', '', $_REQUEST['uid']);
if (empty($uid))
    $uid = uniqid("", true);

if (!empty($_REQUEST['act']) and in_array($_REQUEST['act'], ['add', 'remove', 'minus', 'plus', 'set_count'])) {

    $item['uid'] = $uid;
    $item['item_id'] = (int)$_REQUEST['item_id'];
    if(!empty($_REQUEST['count']))
        $item['count'] = (int)$_REQUEST['count'];

    if (in_array($_REQUEST['act'], ['set_count', 'minus', 'plus'])) {
        $row = DbHelper::get_row("SELECT id,count FROM shop_basket WHERE uid = '{$uid}' AND item_id = '{$item['item_id']}'");
        if (!empty($row['id'])) {
            $item['count'] = $row['count'];
            $item['id'] = $row['id'];
        }

        if ($_REQUEST['act'] == 'set_count')
            $item['count'] = (int)$_REQUEST['count'];

        if (!empty($row['id'])) {
            if ($_REQUEST['act'] == 'minus')
                $item['count'] = $item['count'] - 1;
            if ($_REQUEST['act'] == 'plus')
                $item['count'] = $item['count'] + 1;
        }
    }

    if (in_array($_REQUEST['act'], ['add', 'minus', 'plus', 'set_count']))
        $Basket->save($item);
    if ($_REQUEST['act'] == 'remove')
        DbHelper::delete('shop_basket', "uid = '{$uid}' AND item_id = '{$item['item_id']}'");
}

$Res = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100]);
$Res['pager']['total'] = $Res['pager']['filtered'];
$Res['uid'] = $uid;
$Res['$item'] = $item;