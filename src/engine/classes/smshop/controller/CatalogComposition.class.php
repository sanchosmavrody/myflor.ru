<?php

class CatalogComposition extends Core
{
    var string $table = '';
    var array $filters = [
        'id' => ["where" => "id = '{value}'"],
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

    function processList(array &$data): void
    {
        $Composition = new Composition('shop_composition');
        foreach ($data as &$item) {
            $Res = $Composition->getItem($item['composition_id']);
            $item['composition'] = $Res['item'];
            $item['composition_id'] = $Res['item']['title'];
            $item['price'] = $Res['item']['price'];
            $item['total'] = $Res['item']['price'] * $item['count'];
        }
    }

}