<?php
$Basket = new Basket('shop_basket');

//Во всех запросах передается UID, если он пустой генерим и на фронте положим в локал сторадж
$uid = preg_replace('/[^a-z\d]/ui', '', $_REQUEST['uid']);
if (empty($uid))
    $uid = uniqid("", true);

if (!empty($_REQUEST['act']) and in_array($_REQUEST['act'], ['add'])) {
    $item['uid'] = $uid;
    $Res = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100]);
}

$Res['pager']['total'] = $Res['pager']['filtered'];
$Res['uid'] = $uid;


if ($_REQUEST['act'] === 'add') {

    $basket_items = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100], [], ['full']);

    $phone = CrmHelper::cleanPhone($_REQUEST['phone']);
    $phoneP = null;
    if (isset($_REQUEST['phoneP']))
        $phoneP = CrmHelper::cleanPhone($_REQUEST['phoneP']);

    if ($phone)
        $Res = CrmHelper::order_add(
            CrmHelper::Order($basket_items['data'],
                $phone,
                'courier',
                '',
                $_REQUEST['comment'],
                $phoneP,
                null,
                '',
                '',
                '',
                '',
                date('Y-m-d'),
                '',
                '')
        );

}



