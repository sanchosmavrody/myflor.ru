<?php

class Composition extends Core
{
    var string $table = '';
    var array $filters = [
        'id'           => ["where" => "id = '{value}'"],
        'search_query' => ["where" => "field_8.field_value LIKE '%{value}%' OR field_14.field_value LIKE '%{value}%' "],
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

}