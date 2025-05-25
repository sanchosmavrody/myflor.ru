<?php
$Basket = new Basket('shop_basket');

//Во всех запросах передается UID, если он пустой генерим и на фронте положим в локал сторадж
$uid = preg_replace('/[^a-z\d]/ui', '', $_REQUEST['uid']);
if (empty($uid))
    $uid = uniqid("", true);


$Res['uid'] = $uid;
$Res['messages'] = [];
$defState = [
    'messages'     => [],
    'address'      => '',
    'addressPoint' => '',
    'apartment'    => '',
    'date'         => date('Y-m-d'),
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
        $Res['paymentType'],
        '',
        '',
        null,
        null,
        null,
        null,
        null,
        null,
        $Res['date'],
        null,
        null);

    $Res['totalSumm'] = $order['totalSumm'];
    $Res['delivery'] = [
        'price' => $order['TableCheck']['TableDost'][0]['price'],
        'des'   => $order['TableCheck']['TableDost'][0]['des']
    ];

}
if ($_REQUEST['act'] == 'calc') {
    $Res['basket'] = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100], [], ['full']);


    if (empty($Res['messages'])) {
        $phone = CrmHelper::cleanPhone($_REQUEST['phone']);

        $order = CrmHelper::Order($Res['basket']['data'],
            $phone,
            $_REQUEST['paymentType'],
            '',
            '',
            null,
            null,
            null,
            null,
            $_REQUEST['addressPoint'],
            null,
            $_REQUEST['date'],
            null,
            null);

        CrmHelper::order_calc($order);//рекулькуляция - посчитает доставку и проведет валидацию

        $Res['totalSumm'] = $order['totalSumm'];
        $Res['delivery']['price'] = $order['TableCheck']['TableDost'][0]['price'];
        $Res['delivery']['des'] = $order['TableCheck']['TableDost'][0]['des'];
    }

//    foreach ($order['orderItems'] as $orderItem) {
//        $Res['basket']['data'][] = [
//            'id'         => $orderItem['itemid'],
//            'item_id'    => $orderItem['itemid'],
//            'count'      => $orderItem['count'],
//            'title'      => $orderItem['title'],
//            'price'      => $orderItem['price'],
//            'photo_main' => $orderItem['photo1'],
//            'total'      => $orderItem['count'] * $orderItem['price']
//        ];
//    }
}

if ($_REQUEST['act'] == 'add') {


    if (empty($_REQUEST['phone']))
        $Res['messages'][] = ['type' => 'danger', 'text' => 'Укажите номер телефона'];
    if (empty($_REQUEST['date']))
        $Res['messages'][] = ['type' => 'danger', 'text' => 'Укажите дату доставки'];
    if (empty($_REQUEST['time']))
        $Res['messages'][] = ['type' => 'danger', 'text' => 'Укажите время доставки'];

    if (empty($Res['messages'])) {

        $basket_items = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100], [], ['full']);
        $phone = CrmHelper::cleanPhone($_REQUEST['phone']);
        $phoneP = null;
        if (isset($_REQUEST['phoneP']))
            $phoneP = CrmHelper::cleanPhone($_REQUEST['phoneP']);

        $time = explode('-', $_REQUEST['time']);

        $order = CrmHelper::Order($basket_items['data'],
            $phone,
            $_REQUEST['paymentType'],
            $_REQUEST['name'],
            $_REQUEST['comment'],
            $phoneP,
            $_REQUEST['nameP'],
            '',
            $_REQUEST['address'],
            $_REQUEST['addressPoint'],
            $_REQUEST['apartment'],
            $_REQUEST['date'],
            $time[0],
            $time[1]);

        CrmHelper::order_calc($order);//рекулькуляция - посчитает доставку и проведет валидацию
        $Res['order'] = CrmHelper::order_add($order);

    }
}



