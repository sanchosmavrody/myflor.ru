<?php

class Core
{
    var string $table = '';
    var array $filters = [
        'id' => ["where" => "id = '{value}'"],
    ];

    var array $debug = [];

    /**
     * Получить данные
     * var @array $filter
     * var @array $pager
     * var @array $sorter
     * var @array $params ['item']
     * return @array ['data' => []]
     */
    protected function get(array $filter = [], array $pager = [], array $sorter = [], array $params = []): array
    {

        $LIMIT = 100;
        $sql_ORDER = 'ORDER BY id DESC';

        $sql_WHERE = [];
        $sql_JOIN = [];
        $sql_COLUMNS = '';

        ReqHelper::applyPager($pager, $LIMIT);
        ReqHelper::applySorter($sorter, $sql_ORDER);
        ReqHelper::applyFilter($this->filters, $filter, $sql_WHERE, $sql_JOIN);
        FieldsHelper::applySql($this->table, [], $sql_COLUMNS, $sql_JOIN);
        ReqHelper::compileParts($sql_WHERE, $sql_JOIN);

        $sql_FROM = "FROM {$this->table} {$sql_JOIN}";

        $this->debug['sql_JOIN'] = $sql_JOIN;
        $this->debug['sql_WHERE'] = $sql_WHERE;
        $this->debug['table'] = $this->table;

        if (in_array('item', $params)) {
            $Res['item'] = DbHelper::get_row("SELECT {$this->table}.* {$sql_COLUMNS} {$sql_FROM} {$sql_WHERE} LIMIT 1");
            $this->processItem($Res['item']);
            return $Res;
        }

        $Res['pager'] = ReqHelper::compilePager("SELECT (SELECT COUNT({$this->table}.id) as total {$sql_FROM}) as total, 
        (SELECT COUNT({$this->table}.id) as filtered {$sql_FROM} {$sql_WHERE}) as filtered", $pager);
        $Res['totals'] = false;

        $Res['data'] = [];
        if (!empty($Res['pager']['filtered']))
            $Res['data'] = DbHelper::get("SELECT {$this->table}.* {$sql_COLUMNS} {$sql_FROM} {$sql_WHERE} {$sql_ORDER} LIMIT {$LIMIT}");

        $this->debug['pager'] = $pager;

        $this->processList($Res);
        return $Res;
    }

    function getAsOptions(array $filter = [], array $pager = [], array $sorter = [], array $params = ['name' => 'title', 'value' => 'id']): array
    {
        $Res = [1];

        if (!empty($params['name']) and !empty($params['value'])) {
            $Res = self::get($filter, $pager, $sorter, $params);
            foreach ($Res['data'] as &$item)
                $item = [
                    'name'  => $item[$params['name']],
                    'value' => $item[$params['value']]
                ];

            return $Res['data'];
        }
        return $Res;
    }

    function processItem(array &$item)
    {
        //foreach ($Res['data'] as &$row){
        //
        //}
    }

    function processList(array &$Res): void
    {

    }

    function save(array $item): int
    {
        if (empty($item['id']))
            $item['id'] = DbHelper::add($this->table, $item);
        else
            DbHelper::update($this->table, $item, "id='{$item['id']}'");
        FieldsHelper::save($this->table, $item);
        return $item['id'];
    }

    /**
     * Удалить объект
     * var @int $id
     */
    function delete(int $id): void
    {
        DbHelper::delete($this->table, "id = '{$id}'");
    }
}