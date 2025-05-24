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
    'paymentType'  => 'courier',
    'totalSumm'    => 0
];

$Basket = new Basket('shop_basket');

if ($_REQUEST['act'] == 'get') {
    $Res = $defState;
    $Res['basket'] = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100], [], ['full']);

    $order = CrmHelper::Order($Res['basket']['data'],
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

    $Res['totalSumm'] = $order['totalSumm'];

}
if ($_REQUEST['act'] == 'calc') {
    $basket_items = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100], [], ['full']);


    $Res['basket'] = [];


    foreach ($order['orderItems'] as $orderItem) {
        $Res['basket']['data'][] = [
            'id'         => $orderItem['itemid'],
            'item_id'    => $orderItem['itemid'],
            'count'      => $orderItem['count'],
            'title'      => $orderItem['title'],
            'price'      => $orderItem['price'],
            'photo_main' => $orderItem['photo1'],
            'total'      => $orderItem['count'] * $orderItem['price']
        ];
    }
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



