<?php
$Basket = new Basket('shop_basket');

//Во всех запросах передается UID, если он пустой генерим и на фронте положим в локал сторадж
$uid = preg_replace('/[^a-z\d]/ui', '', $_REQUEST['uid']);
if (empty($uid))
    $uid = uniqid("", true);

if (!empty($_REQUEST['act']) and in_array($_REQUEST['act'], ['add'])) {

    $item['uid'] = $uid;

    $Res = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100]);


    //$Res['data']

}

$Res['pager']['total'] = $Res['pager']['filtered'];
$Res['uid'] = $uid;


if ($_REQUEST['act'] == 'test') {
    $Basket = new Basket('shop_basket');

    $uid = preg_replace('/[^a-z\d]/ui', '', $_REQUEST['uid']);

    function OrderPayment(string $method, int $amount)
    {
        $methodIdByAlt = ['online' => 16, 'store' => 14, 'courier' => 12, 'rs' => 17];
        return [
            'bitrix_id'      => 0,
            'order_id'       => 0,
            'method_id'      => $methodIdByAlt[$method],
            'status_id'      => 1,
            'amount'         => 100,
            'account_number' => '',
            'type_id'        => 1 // полный расчет
        ];
    }

    function OrderTableCheck(string $des, int $price)
    {
        return ["TableDost" => [["des" => $des, "price" => $price]], "TableItems" => []];

    }

    function OrderItems(&$totalSumm, $basket)
    {
        $items = [];
        foreach ($basket as $basket_item) {
            $items[$basket['id']] = [
                'id'                 => 13,
                'itemid'             => 13,
                'Assembled'          => '1',
                'count'              => 2,
                'level'              => 0,
                'photo1'             => '',
                'title'              => 'Веник',
                'price'              => 1000,
                'coast'              => 1000,
                'profit'             => 0,
                'ProductComposition' => [
                    ['ID' => 1, 'AMOUNT' => 1, 'COAST' => 1, 'COSTPRICE' => 1, 'PROFIT' => 1]
                ],
            ];
        }
        return $items;

    }


    $basket_items = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100]);
    function Order($basket,
                   int $PhoneI,
                   string|null $NameI,
                   string|null $Comment,
                   int|null $PhoneP,
                   string|null $NameP,
                   string|null $card,
                   string|null $Adress,
                   string|null $AdressPoint,
                   string|null $Apartments,
                   string|null $Date,
                   string|null $TimeFrom,
                   string|null $TimeTo
    ): array
    {


        $totalSumm = 0;
        $orderItems = OrderItems($totalSumm, $basket);
        return [
            "AdminComments" => $card ? '#Записка: ' . $card : '',
            "Adress"        => $Adress . " кв./офис " . $Apartments,
            "AdressPoint"   => $AdressPoint ?? '',
            "src"           => "myflor.ru",
            "shop"          => "MFL",
            "Comment"       => $Comment ?? '',
            "PhoneI"        => $PhoneI,
            "NameI"         => $NameI ?? '',
            "PhoneP"        => $PhoneP ?? '',
            "NameP"         => $NameP ?? '',
            "courierName"   => '',//может быть самовывоз
            "orderItems"    => $orderItems,
            "TableCheck"    => OrderTableCheck('Москва', 400),
            "payments"      => [OrderPayment('online', 1)],
            "Date"          => $Date ?? date('Y-m-d'),
            "TimeFrom"      => $TimeFrom ?? "00:00",
            "TimeTo"        => $TimeTo ?? "00:00",
            "totalSumm"     => $totalSumm,
            "paymentType"   => "cash",
        ];
    }


    $Res = CrmHelper::order_add(Order($basket_items['data'], 70000000,
        '',
        '',
        null,
        null,
        '',
        '',
        '',
        '',
        date('Y-m-d'),
        '',
        ''));
}


