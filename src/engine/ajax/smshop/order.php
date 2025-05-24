<?php
$Basket = new Basket('shop_basket');

//Во всех запросах передается UID, если он пустой генерим и на фронте положим в локал сторадж
$uid = preg_replace('/[^a-z\d]/ui', '', $_REQUEST['uid']);
if (empty($uid))
    $uid = uniqid("", true);


$Res['uid'] = $uid;
$defState = [
    'address'      => '',
    'addressPoint' => '',
    'apartment'    => '',
    'date'         => '',
    'time'         => '',
    'name'         => '',
    'phone'        => '',
    'nameP'        => '',
    'phoneP'       => '',
    'basket'       => ['data' => []],
    'delivery'     => [
        'price' => 0,
        'des'   => ''
    ],
    'paymentType'  => 'courier'
];

$Basket = new Basket('shop_basket');

if ($_REQUEST['act'] == 'get') {

    $basket_items = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100], [], ['full']);


    $Res['item'] = CrmHelper::Order($basket_items['data'],
        0,
        'courier',
        '',
        '',
        null,
        null,
        null,
        null,
        null,
        null,
        date('Y-m-d'),
        null,
        null);

}

if ($_REQUEST['act'] == 'add') {

    $basket_items = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100], [], ['full']);

    $phone = CrmHelper::cleanPhone($_REQUEST['phone']);
    $phoneP = null;
    if (isset($_REQUEST['phoneP']))
        $phoneP = CrmHelper::cleanPhone($_REQUEST['phoneP']);

    if ($phone)
        $Res = CrmHelper::order_add(
            CrmHelper::Order($basket_items['data'],
                $phone,
                'cash',
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
                ''));

}



