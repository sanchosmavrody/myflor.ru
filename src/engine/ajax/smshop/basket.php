<?php
$Basket = new Basket('shop_basket');

//Во всех запросах передается UID, если он пустой генерим и на фронте положим в локал сторадж
$uid = preg_replace('/[^a-z\d]/ui', '', $_REQUEST['uid']);
if (empty($uid))
    $uid = uniqid("", true);

if (!empty($_REQUEST['act']) and ($_REQUEST['act'] == 'add' or $_REQUEST['act'] == 'remove')) {

    $item['uid'] = $uid;
    $item['count'] = (int)$_REQUEST['count'];
    $item['item_id'] = (int)$_REQUEST['item_id'];

    if ($_REQUEST['act'] == 'add')
        $Basket->save($item);
    if ($_REQUEST['act'] == 'remove')
        DbHelper::delete('shop_basket', "uid = '{$uid}' AND item_id = '{$item['item_id']}'");
}

$Res = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100]);
$Res['uid'] = $uid;