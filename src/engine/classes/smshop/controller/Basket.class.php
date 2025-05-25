<?php

class Basket extends Core
{
    var string $table = '';
    var array $filters = [
        'id'      => ["where" => "id = '{value}'"],
        'uid'     => ["where" => "uid = '{value}'"],
        'item_id' => ["where" => "item_id = '{value}'"],
    ];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    function getList(array $filter = [], array $pager = [], array $sorter = [], array $params = []): array
    {
        $Res = parent::get($filter, $pager, $sorter, $params);
        if (in_array('full', $params))
            $this->fillFull($Res['data']);
        return $Res;
    }

    private function fillFull(&$basket): void
    {
        $Catalog = new Catalog('shop_catalog');
        $CatalogComposition = new CatalogComposition('shop_catalog_composition');
        foreach ($basket as &$item) {
            $item['item'] = $Catalog->getItem($item['item_id']);
            $item['item'] = $item['item']['item'];
            $item['item']['composition'] = $CatalogComposition->getList(['parent_id' => $item['item_id']], ['current' => 0, 'limit' => 100]);
            $item['item']['composition'] = $item['item']['composition']['data'];
        }
    }

    function getItem(int $id): array
    {
        return parent::get(['id' => $id], [], [], ['item']);
    }

    function save(array $item): int
    {
        global $member_id;
        //if ($item['id'] == 0)
        $item['user_id'] = $member_id['user_id'];
        $item['count'] = (int)$item['count'];
        if ($item['count'] < 1)
            $item['count'] = 1;
        return parent::save($item);
    }

    function processList(array &$Res): void
    {
        $Catalog = new Catalog('shop_catalog');
        $total = 0;
        foreach ($Res['data'] as &$item) {
            $catalog_item = $Catalog->getItem($item['item_id'])['item'];
            foreach (['title', 'price', 'category_2_name', 'photo_main',] as $field_to_map)
                $item[$field_to_map] = $catalog_item[$field_to_map];
            //$item['item'] = $catalog_item;
            $item['total'] = $item['count'] * $item['price'];
            $total += $item['total'];
        }

        $Res['totals'] = ['total' => $total];
    }
}