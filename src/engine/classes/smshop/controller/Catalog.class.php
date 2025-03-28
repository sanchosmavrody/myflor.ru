<?php

class Catalog extends Core
{
    var string $table = '';
    var array $filters = [
        'id'         => ["where" => "id = '{value}'"],
        'category_2' => ["where" => "field_17.field_value = '{value}'"],
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

//    function save(array $item): int
//    {
//        return parent::save($item);
//    }

    function processList(array &$data): void
    {
        foreach ($data as &$item) {
            //костыли для справочников авто

            $item['category_2'] = DbHelper::get_row("SELECT field_value FROM shop_category_fields WHERE shop_category = '{$item['category_2']}' and field = 3;")['field_value'];

            $item['active_site'] = $item['active_site'] == 1 ? 'Да' : 'Нет';
            $item['active_main'] = $item['active_main'] == 1 ? 'Да' : 'Нет';

        }

    }

}