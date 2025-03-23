<?php

class Category extends Core
{
    var string $table = '';
    var array $filters = [
        'id'    => ["where" => "id = '{value}'"],
        'title' => ["where" => "field_3.field_value = '{value}'"],
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
            //костыли для справочников авто
            //$item['mark'] = DbHelper::get_row("SELECT * FROM mark WHERE id = '{$item['mark']}'");
            //$item['model'] = DbHelper::get_row("SELECT * FROM model WHERE id = '{$item['model']}'");
            //$item['generation'] = DbHelper::get_row("SELECT * FROM generation WHERE id = '{$item['generation']}'");
            //$item['mark'] = DbHelper::get_row("SELECT * FROM mark WHERE id = '{$item['mark']}'");
        }

    }

    function processItem(array &$item): void
    {

    }


}