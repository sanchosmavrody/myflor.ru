<?php

class ReqHelper
{
    static function applyPager(array $pager, string &$sql_LIMIT): void
    {
        if (!empty($pager) and isset($pager['current']) and isset($pager['limit']))
            $sql_LIMIT = ($pager['current'] * $pager['limit']) . ",{$pager['limit']}";
    }

    static function applySorter(array $sorter, string &$sql_ORDER): void
    {
        if (!empty($sorter)) {
            $list = [];
            foreach ($sorter as $item)
                if (isset($item['field']) and isset($item['direction']))
                    $list[] = " {$item['field']} {$item['direction']} ";

            $sql_ORDER = " ORDER BY " . implode('', $list);
        }
    }

    static function applyFilter(array $settings, array $filter, array &$sql_WHERE, array &$sql_JOIN): void
    {
        if (!empty($filter))
            foreach ($settings as $field => $item)
                if (isset($filter[$field]) and $filter[$field] !== '') {
                    $filter[$field] = trim(str_replace(',', "','", $filter[$field]));
                    if (!empty($item['where']))
                        $sql_WHERE[] = str_replace('{value}', $filter[$field], $item['where']);
                    if (!empty($item['join']))
                        $sql_JOIN[] = str_replace('{value}', $filter[$field], $item['join']);
                }
    }

    static function compileParts(&$sql_WHERE, array &$sql_JOIN): void
    {
        if (!empty($sql_WHERE))
            $sql_WHERE = ' WHERE ' . implode(' AND ', $sql_WHERE);
        else $sql_WHERE = '';
        if (!empty($sql_JOIN))
            $sql_JOIN = implode('
', $sql_JOIN);
        else $sql_JOIN = '';
    }

    static function compilePager(string $sql_pager, $req_pager)
    {
        if (empty($req_pager))
            return false;
        $pager = DbHelper::get_row($sql_pager);
        $pager['current'] = $req_pager['current'];
        $pager['limit'] = $req_pager['limit'];
        return $pager;
    }
}

class DbHelper
{
    static function delete($tableName, $whereParams)
    {
        global $db;
        $db->query("DELETE FROM {$tableName}  WHERE {$whereParams}");
    }

    static function query($sql)
    {
        global $db;
        $db->query($sql);
    }

    static function add($tableName, $params): int
    {
        global $db;
        $data = [];
        $table_fields = self::load_table_fields($tableName);
        //Сверка полей
        foreach ($table_fields as $field)
            if (isset($params[$field])) {
                $data['fields'][] = "{$field}";
                $data['values'][] = "'{$params[$field]}'";
            }

        $values = implode(', ', $data['values']);
        $fields = implode(', ', $data['fields']);
        $db->query("INSERT INTO {$tableName} ({$fields}) VALUES ({$values}) ;");
        return $db->insert_id();
    }

    static function update($tableName, $row, $strWhere)
    {
        global $db;
        $table_fields = self::load_table_fields($tableName);
        $data = [];
        foreach ($table_fields as $field)
            if (isset($row[$field]))
                $data[] = " {$field} = '{$row[$field]}' ";

        $data = implode(", ", $data);

        return $db->query("UPDATE {$tableName} SET {$data} WHERE {$strWhere} ");
    }

    static function get($sql)
    {
        global $db;
        return $db->super_query($sql, true);
    }

    static function get_row($sql)
    {
        global $db;
        return $db->super_query($sql);
    }

    static function load_table_fields($table)
    {
        $arrFields = [];
        $fieldsList = self::get('SHOW COLUMNS FROM ' . $table);
        foreach ($fieldsList as $fieldString)
            $arrFields[] = $fieldString['Field'];
        return $arrFields;
    }
}

class FieldsHelper
{
    /**
     * Показать дополнительные поля
     * var @string $item_type - тип объекта, должен совпадать с названием таблицы базового объекта
     * var @array $item - сам объект, или массив с обязательным полем id и полями к сохранению
     * return @string - готовые формы обёрнутые в div.col-md-*
     */
    static function generate(array $fields, array $item = []): string
    {

        foreach ($fields as $field) {
            if ($field['control_type'] == 'input') {
                $req = $field['req'] ? 'required' : '';
                $value = '';
                if (!empty($item[$field['name']]))
                    $value = $item[$field['name']];
                $description = '';
                if ($field['description'])
                    $description = <<<HTML
<span style="height: 17px;" class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" title="{$field['description']}" data-original-title="" title_="Описание">?</span>
HTML;
                $echo_by_group[$field['group_name']][] = <<<HTML
        <div class="col-md-{$field['size']} fields-gen">
            <h6>{$field['label']}{$description}</h6>
            <input type="text"  name="{$field['name']}" value="{$value}" {$req} placeholder="{$field['placeholder']}">
        </div>
HTML;
            }
            if ($field['control_type'] == 'upload') {
                $req = $field['req'] ? 'required' : '';
                $value = '';
                if (!empty($item[$field['name']]))
                    $value = $item[$field['name']];
                $description = '';
                if ($field['description'])
                    $description = <<<HTML
<span style="height: 17px;" class="help-button" data-rel="popover" data-trigger="hover" data-placement="right" title="{$field['description']}" data-original-title="" title_="Описание">?</span>
HTML;
                $preview = '';
                if ($value) {
                    $parts = explode('.', $value);
                    if (in_array('.' . end($parts), ['.jpg', '.jpeg', '.gif', '.png', '.svg']))
                        $preview = <<<HTML
<img src="{$value}" alt="" style="width: auto; height: auto" >
HTML;
                    else if (in_array('.' . end($parts), ['.html'])) {
                        $parts = explode(' ', $field['label']);
                        $parts = explode('x', $parts[1]);
                        $preview = <<<HTML
<iframe src="{$value}"  class="show_ru" style="width: {$parts[0]}px; height: {$parts[1]}px;box-shadow: 0px 0px 7px #000;    border: 0;"></iframe>
HTML;
                    }
                }


                $echo_by_group[$field['group_name']][] = <<<HTML
        <div class="col-md-{$field['size']} fields-gen">
            <h6>{$field['label']}{$description}</h6>
            <input type="file"  name="{$field['name']}" value="{$value}" {$req} placeholder="{$field['placeholder']}">
            {$preview}
        </div>
HTML;
            }
        }

        $Res = [];
        foreach ($echo_by_group as $group_name => $echo) {
            $echo = implode('', $echo);
            $Res[] = <<<HTML
<h4>{$group_name}</h4><div class="row">{$echo}</div>
HTML;
        }

        return implode('', $Res);
    }

    /**
     * Сохранить дополнительные поля
     * var @string $item_type - тип объекта, должен совпадать с названием таблицы базового объекта
     * var @array $item - сам объект, или массив с обязательным полем id и полями к сохранению
     * var ?@array $files_to_upload - загружаемые файлы
     * return array
     */
    static function save(string $item_type, array $item, ?array $files_to_upload = []): array
    {
        global $db;
        $Error = [];
        $fields = self::get($item_type);
        foreach ($fields as $field) {

            if ((!isset($item[$field['name']]) and empty($files_to_upload[$field['name']])) or empty($item['id'])) continue;

            if (in_array($field['control_type'], ['input', 'text', 'select','select_multi', 'select_ajax', 'radio', 'checkbox', 'textarea', 'upload_img', 'upload_img_gallery'])) {
                DbHelper::query("INSERT INTO {$item_type}_fields (`{$item_type}`,field,field_value)
                    VALUES ('{$item['id']}','{$field['id']}','{$item[$field['name']]}')
                    ON DUPLICATE KEY UPDATE field_value = '{$item[$field['name']]}';");
            } else if (in_array($field['control_type'], ['upload']) and $field['control_params']) {
                $field['control_params'] = explode('||', $field['control_params']);
                $ext = '.' . substr($files_to_upload[$field['name']]['name'], -strpos(strrev($files_to_upload[$field['name']]['name']), '.'));
                $folder = str_replace(['{id}'], [$item['id']], $field['control_params'][0]);//
                $file_name = str_replace(['{id}', '{field_id}', '{time}'], [$item['id'], $field['id'], time()], $field['control_params'][1]);//  {id}_{field_id}_{time}
                $dist_file_patch = $folder . $file_name . $ext;//

                if (!empty($files_to_upload[$field['name']]['tmp_name']))
                    if (is_dir(ROOT_DIR . $folder) or mkdir(ROOT_DIR . $folder)) //
                        if (move_uploaded_file($files_to_upload[$field['name']]['tmp_name'], ROOT_DIR . $dist_file_patch)) {
                            if (in_array($ext, ['.jpg', '.jpeg', '.gif', '.png', '.svg']))
                                $db->query("INSERT INTO {$item_type}_fields (item_id,field_id,field_value)
                                    VALUES ('{$item['id']}','{$field['id']}','{$dist_file_patch}')
                                    ON DUPLICATE KEY UPDATE field_value = '{$dist_file_patch}';");

                            if (in_array($ext, ['.zip'])) {
                                $folder = $folder . $field['id'] . '/';
                                $zip = new ZipArchive;
                                if (($res = $zip->open(ROOT_DIR . $dist_file_patch)) === TRUE) {
                                    if (is_dir(ROOT_DIR . $folder) or mkdir(ROOT_DIR . $folder)) {
                                        $zip->extractTo(ROOT_DIR . $folder);
                                        $zip->close();
                                        unlink($dist_file_patch);
                                        $db->query("INSERT INTO {$item_type}_fields (item_id,field_id,field_value)
                                    VALUES ('{$item['id']}','{$field['id']}','{$folder}index.html')
                                    ON DUPLICATE KEY UPDATE field_value = '{$folder}index.html';");
                                    } else
                                        $Error[] = 'Не удалось создать папку ' . ROOT_DIR . $folder;
                                } else
                                    $Error[] = 'Не удалось распаковать архив ' . $dist_file_patch;
                            }
                        } else
                            $Error[] .= ' Не удалось создать ' . $folder;
            }
        }
        return $Error;
    }

    /**
     * Получить поля
     * var @string $item_type - тип объекта, должен совпадать с названием таблицы базового объекта
     * var @array $item - сам объект, если передан то будут заполнены поля со значениями
     * return @array<string,string>  $fields[$name] - поля иих настройки для отрисовки формы
     */
    static function get(string $item_type, array &$item = [], string $custom_where = ''): array
    {
        if ($custom_where)
            $custom_where = ' and ' . $custom_where;
        if (!empty($item))
            $fields = DbHelper::get("
SELECT FV.field_value, fields.*
FROM fields 
LEFT JOIN {$item_type}_fields as FV ON FV.field = fields.id and FV.{$item_type} = '{$item['id']}'
WHERE fields.item_type = '{$item_type}' {$custom_where}
ORDER BY sorter ASC;
");
        else
            $fields = DbHelper::get("
SELECT fields.*
FROM fields 
WHERE fields.item_type = '{$item_type}' {$custom_where}
ORDER BY sorter ASC;
");
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
                LEFT JOIN {$item_type}_fields as field_{$field['id']} ON field_{$field['id']}.field = {$field['id']} and field_{$field['id']}.{$item_type} = {$main_table_alias}.id";
                $sql['columns'][] = "field_{$field['id']}.field_value as {$field['name']}";
            }
        return ['join' => implode(' ', $sql['join']), 'columns' => implode(', ', $sql['columns'])];
    }

    static function applySql(string $item_type, array $fields_compile, string &$sql_COLUMNS, array &$sql_JOIN, array $fields = [], string $main_table_alias = ''): void
    {
        $fields_sql = self::get_sql($item_type, $fields_compile, $fields, $main_table_alias);
        if ($fields_sql['join'])
            $sql_JOIN[] = $fields_sql['join'];
        if ($fields_sql['columns'])
            $sql_COLUMNS = ',' . $fields_sql['columns'];
    }

}

class FilesHelper
{
    static string $upload_dir = "/uploads";

    static function get_ext_from_url($url): string
    {
        $url = explode('.', $url);
        return empty($url) ? '' : end($url);
    }

    static function save($file_tmp_name, $dir, $fileName): bool
    {
        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $dir))
            mkdir($_SERVER['DOCUMENT_ROOT'] . $dir, 0777, true);
        $res = @move_uploaded_file($file_tmp_name, $_SERVER['DOCUMENT_ROOT'] . $dir . $fileName);
        if ($res) {
            @chmod($_SERVER['DOCUMENT_ROOT'] . $dir . $fileName, 0666);
            return true;
        }
        return false;
    }

    static function save_from_url($url, $dir, $file_name): string
    {

        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $dir))
            mkdir($_SERVER['DOCUMENT_ROOT'] . $dir, 0777, true);

        $ch = curl_init($url);
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . $dir . $file_name, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return $dir . $file_name;
    }

    static function clear_dir($dir)
    {
        $includes = new FilesystemIterator($dir);
        foreach ($includes as $include) {
            if (is_dir($include) && !is_link($include))
                self::clear_dir($include);
            else
                unlink($include);
        }
        //rmdir($dir);
    }

}