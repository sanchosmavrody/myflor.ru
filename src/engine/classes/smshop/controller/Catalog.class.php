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

    function save(array $item): int
    {
        global $member_id;
        //if ($item['id'] == 0)
        $item['user_id'] = $member_id['user_id'];

        $id = parent::save($item);
        if ($item['id'] == 0) {
            DbHelper::query("UPDATE shop_catalog_composition SET parent_id = '{$id}' WHERE user_id = '{$member_id['user_id']}' AND parent_id = 0; ");
        }
        return $id;
    }

    function processList(array &$Res): void
    {
        foreach ($Res['data'] as &$item) {
            $this->processItem($item);
            // unset($item['photos']);
        }
    }

    function processItem(array &$item): void
    {
        $item['user_id'] = DbHelper::get_row("SELECT name FROM dle_users WHERE user_id = '{$item['user_id']}' ")['name'];
        $item['category_2'] = DbHelper::get_row("SELECT field_value FROM shop_category_fields WHERE shop_category = '{$item['category_2']}' and field = 3;")['field_value'];
        $item['active_site'] = $item['active_site'] == 1 ? 'Да' : 'Нет';
        $item['active_main'] = $item['active_main'] == 1 ? 'Да' : 'Нет';

        $item['photos'] = explode(',', $item['photos']);
        $item['photo_main'] = empty($item['photos'][0]) ? '/templates/Full/assets/img/catalog_no_photo.png' : $item['photos'][0];
    }
}