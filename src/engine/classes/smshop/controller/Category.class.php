<?php

class Category extends Core
{
    var string $table = '';
    var array $filters = [
        'id'           => ["where" => "id = '{value}'"],
        'title'        => ["where" => "field_3.field_value = '{value}'"],
        'search_query' => ["where" => "field_3.field_value = '{value}'"],
        'parent_id'    => ["where" => "field_4.field_value = '{value}'"],
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
        foreach ($data as &$item) {
            $item['parent_id'] = DbHelper::get_row("SELECT field_value FROM shop_category_fields WHERE shop_category = '{$item['parent_id']}' and field = 3;")['field_value'];
        }
    }

    function processItem(array &$item): void
    {

    }


}