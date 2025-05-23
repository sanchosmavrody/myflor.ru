<?php

class CatalogComposition extends Core
{
    var string $table = '';
    var array $filters = [
        'id'        => ["where" => "id = '{value}'"],
        'parent_id' => ["where" => "parent_id = '{value}'"],
        'user_id'   => ["where" => "user_id = '{value}'"],
    ];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    function getList(array $filter = [], array $pager = [], array $sorter = [], array $params = []): array
    {
        return parent::get($filter, $pager, $sorter, $params);
    }

    function getItem(int $id): array
    {
        return parent::get(['id' => $id], [], [], ['item']);
    }

    function processList(array &$Res): void
    {
        $Composition = new Composition('shop_composition');
        foreach ($Res['data'] as &$item) {
            $composition_item = $Composition->getItem($item['composition_id']);
            //$item['composition'] = $composition_item['item'];
            //$item['composition_id'] = $composition_item['item']['title'];
            $item['title'] = $composition_item['item']['title'];
            $item['bitrix_id'] = $composition_item['item']['bitrix_id'];
            $item['category_name'] = $composition_item['item']['category_name'];

            $item['cost'] = $composition_item['item']['cost'];
            $item['total_cost'] = $composition_item['item']['cost'] * $item['count'];

            $item['price'] = $composition_item['item']['price'];
            $item['total'] = $composition_item['item']['price'] * $item['count'];

            $item['total_profit'] = ($composition_item['item']['price'] - $composition_item['item']['cost']) * $item['count'];
        }
    }

    function recalculatePrice(int $parent_id): void
    {
        $Res = $this->getList(['parent_id' => $parent_id], [0, 100]);
        $totals = $totals_cost = $totals_profit = 0;
        foreach ($Res['data'] as $item) {
            $totals += $item['total'];
            $totals_cost += $item['total_cost'];
            $totals_profit += $item['total_profit'];
        }

        $Catalog = new Catalog('shop_catalog');
        $Catalog->save(['id' => $parent_id, 'price' => $totals, 'cost' => $totals_cost, 'profit' => $totals_profit]);
    }

    function save(array $item): int
    {
        if (empty($item['id'])) {
            global $member_id;
            $item['user_id'] = $member_id['user_id'];
        }
        parent::save($item);
        $this->recalculatePrice($item['parent_id']);
        return $item['id'];
    }
}