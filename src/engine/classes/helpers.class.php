<?php


class fields
{
    /**
     * Сохранить дополнительные поля
     * var @string $item_type - тип объекта, должен совпадать с названием таблицы базового объекта
     * var @array $item - сам объект, или массив с обязательным полем id и полями к сохранению
     * return @string - готовые формы обёрнутые в div.col-md-*
     */
    static function generate(array $fields, array $item = []): string
    {
        $echo = [];
        foreach ($fields as $field) {
            if ($field['control_type'] == 'input') {

                $req = $field['req'] ? 'required' : '';
                $value = '';
                if (!empty($item[$field['name']]))
                    $value = $item[$field['name']];
                $description = '';
                if ($field['description'])
                    $description = <<<HTML
<span class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="{$field['description']}" data-original-title="" title="Описание">?</span>
HTML;

                $echo[] = <<<HTML
        <div class="col-md-{$field['size']} fields-gen">
            <h6>{$field['label']}{$description}</h6>
            <input type="text"  name="{$field['name']}" value="{$value}" {$req} placeholder="{$field['placeholder']}">
        </div>
HTML;
            }
        }

        return implode('', $echo);
    }

    /**
     * Сохранить дополнительные поля
     * var @string $item_type - тип объекта, должен совпадать с названием таблицы базового объекта
     * var @array $item - сам объект, или массив с обязательным полем id и полями к сохранению
     */
    static function save(string $item_type, array $item): void
    {
        global $db;
        $fields = self::get($item_type);
        foreach ($fields as $field) {
            $db->query("INSERT INTO {$item_type}_fields (item_id,field_id,field_value)
                    VALUES ('{$item['id']}','{$field['id']}','{$item[$field['name']]}')
                    ON DUPLICATE KEY UPDATE field_value = '{$item[$field['name']]}';");
        }
    }

    /**
     * Получить поля
     * var @string $item_type - тип объекта, должен совпадать с названием таблицы базового объекта
     * var @array $item - сам объект, если передан то будут заполнены поля со значениями
     * return @array $fields[$name] - поля иих настройки для отрисовки формы
     */
    static function get(string $item_type, array &$item = []): array
    {
        global $db;
        if (!empty($item))
            $fields = $db->super_query("
SELECT FV.field_value, fields.*
FROM fields 
LEFT JOIN {$item_type}_fields as FV ON FV.field_id = fields.id and FV.item_id = '{$item['id']}'
WHERE fields.item_type = '{$item_type}';
", true);
        else
            $fields = $db->super_query("
SELECT  fields.*
FROM fields 
WHERE fields.item_type = '{$item_type}';
", true);

        $fields_ = [];
        foreach ($fields as $field) {
            if (!empty($item))
                $item[$field['name']] = $field['field_value'];

            $fields_[$field['name']] = $field;
        }
        return $fields_;
    }

    /**
     * Получить части sql для запроса полей
     * var @string $item_type - тип объекта, должен совпадать с названием таблицы базового объекта
     * var @array $fields_compile - нужные поля, если пусто склеит все
     * var @array $fields - объект справочник полей. Если уже есть в коде выше - передаём, иначе запросит сам.
     * var @string $main_table_alias - основная таблица, по умолчанию = $item_type. Если в запросе используем алиас - передаём его.
     * return @array ['join' => string, 'columns' => string]
     */
    static function get_sql(string $item_type, array $fields_compile = [], array $fields = [], string $main_table_alias = ''): array
    {
        if (empty($fields))
            $fields = self::get($item_type);
        if (empty($main_table_alias))
            $main_table_alias = $item_type;
        $sql = ['join' => [], 'columns' => []];
        foreach ($fields as $field)
            if (empty($fields_compile) or in_array($field['name'], $fields_compile)) {
                $sql['join'][] = "
                LEFT JOIN {$item_type}_fields as field_{$field['id']} ON field_{$field['id']}.field_id = {$field['id']} and field_{$field['id']}.item_id = {$main_table_alias}.id";
                $sql['columns'][] = "field_{$field['id']}.field_value as {$field['name']}";
            }
        return ['join' => implode(' ', $sql['join']), 'columns' => implode(', ', $sql['columns'])];
    }

    static function applySql(string $item_type, array $fields_compile, string &$sql_COLUMNS, array &$sql_JOIN, array $fields = [], string $main_table_alias = ''): void
    {
        $fields_sql = fields::get_sql($item_type, $fields_compile, $fields, $main_table_alias);
        if ($fields_sql['join'])
            $sql_JOIN[] = $fields_sql['join'];
        if ($fields_sql['columns'])
            $sql_COLUMNS = ',' . $fields_sql['columns'];
    }

}

class DataTable
{
    static function applyLimit(array $req, string &$sql_LIMIT): void
    {
        if (isset($req['length']) and isset($req['start']))
            $sql_LIMIT = "{$req['start']},{$req['length']}";
    }

    static function applyOrder(array $columns, array $order, array $allowFields, string &$sql_ORDER): void
    {
        if (isset($order[0]) and $columns[$order[0]['column']]['data'] and
            (in_array($columns[$order[0]['column']]['data'], $allowFields) or empty($allowFields)))
            $sql_ORDER = " ORDER BY {$columns[$order[0]['column']]['data']} {$order[0]['dir']} ";
    }

    static function applyFilter(array $settings, array $filter, array &$sql_WHERE, array &$sql_JOIN): void
    {
        foreach ($settings as $field => $item)
            if (isset($filter) and isset($filter[$field]) and $filter[$field] !== '') {
                $filter[$field] = str_replace(',', "','", $filter[$field]);
                if (!empty($item['where']))
                    $sql_WHERE[] = str_replace('{value}', $filter[$field], $item['where']);
                if (!empty($item['join']))
                    $sql_JOIN[] = str_replace('{value}', $filter[$field], $item['join']);
            }
    }

    static function applySearch(array $settings, string $filter, array &$sql_WHERE, array &$sql_JOIN): void
    {
        $sql_WHERE_OR = [];
        foreach ($settings as $setts)
            if ((isset($filter) and strlen($filter) > 3)) {
                if (!empty($setts['where'])) {
                    $sql_WHERE_OR[] = str_replace('{value}', $filter,
                        str_replace('{value_striped}', str_replace([' ', '-', '.'], '', $filter),
                            $setts['where']));
                }
                if (!empty($setts['join'])) {
                    $sql_JOIN[] = str_replace('{value}', $filter,
                        str_replace('{value_striped}', str_replace([' ', '-', '.'], '', $filter),
                            $setts['join']));
                }
            }

        if (!empty($sql_WHERE_OR))
            $sql_WHERE[] = ' (' . implode(' OR ', $sql_WHERE_OR) . ') ';
    }
}
