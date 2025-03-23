<?php

class Fields extends Core
{
    var string $table = 'fields';
    var array $filters = [
        'id'           => ["where" => "id = '{value}'"],
        'search_query' => ["where" => "item_type LIKE '%{value}%' OR name LIKE '%{value}%' OR group_name LIKE '%{value}%' OR label LIKE '%{value}%' "],
        'item_type'    => ["where" => "item_type = '{value}'  "],
    ];

    public function __construct()
    {

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

    }

    function processItem(array &$item): void
    {

    }

}