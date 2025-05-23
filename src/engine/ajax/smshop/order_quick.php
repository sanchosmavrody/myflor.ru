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
    $Catalog = new Basket('shop_catalog');

    $uid = preg_replace('/[^a-z\d]/ui', '', $_REQUEST['uid']);

    function OrderPayment(string $method, int $amount)
    {
        $methodIdByAlt = ['online' => 16, 'store' => 14, 'courier' => 12, 'rs' => 17];
        return [
            'bitrix_id'      => 0,
            'order_id'       => 0,
            'method_id'      => $methodIdByAlt[$method],
            'status_id'      => 1,
            'amount'         => $amount,
            'account_number' => '',
            'type_id'        => 1 // полный расчет
        ];
    }

    function OrderTableCheck(string $des, int $price)
    {
        return ["TableDost" => [["des" => $des, "price" => $price]], "TableItems" => []];

    }

    function OrderItemsComposition(array $itemComposition): array
    {
        $Res = [];
        foreach ($itemComposition as $item)
            $Res[] = [
                'ID'        => empty($item['bitrix_id']) ? 28 : $item['bitrix_id'],
                'count'     => $item['count'],
                'PRICE'     => $item['price'],
                'COSTPRICE' => $item['cost'],
                'COAST'     => $item['cost'] * $item['count'],
                'PROFIT'    => ($item['price'] - $item['cost']) * $item['count'],
            ];

        return $Res;
    }

    function OrderItems(&$totalSumm, $basket)
    {

        //  return $basket;
        $items = [];
        foreach ($basket as $basket_item) {
            $totalSumm += $basket_item['count'] * $basket_item['price'];
            $items[$basket_item['item_id']] = [
                'id'                 => $basket_item['item_id'],
                'itemid'             => $basket_item['item_id'],
                'Assembled'          => '1',
                'count'              => $basket_item['count'],
                'level'              => 0,
                'photo1'             => 'https://myflor.ru' . $basket_item['photo_main'],
                'title'              => $basket_item['title'],
                'price'              => $basket_item['price'],
                'coast'              => $basket_item['item']['cost'],
                'profit'             => $basket_item['item']['profit'],
                'ProductComposition' => OrderItemsComposition($basket_item['item']['composition']),
            ];
        }
        return $items;
    }


    function Order($basket,
                   int $PhoneI,
                   string|null $paymentType,
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
            "payments"      => [OrderPayment($paymentType, $totalSumm)],
            "Date"          => $Date ?? date('Y-m-d'),
            "TimeFrom"      => $TimeFrom ?? "00:00",
            "TimeTo"        => $TimeTo ?? "00:00",
            "totalSumm"     => $totalSumm,
            "paymentType"   => "cash",
        ];
    }


    $basket_items = $Basket->getList(['uid' => $uid, 'order_id' => 0], ['current' => 0, 'limit' => 100], [], ['full']);

    $Res = CrmHelper::order_add(
        Order($basket_items['data'],
            70000000,
            'cash',
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


