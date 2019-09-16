<?php

namespace huoban\models;

use huoban\helpers\Curl_http;

class HuobanTable
{

    /**
     * get
     *
     * @param  integer $table_id
     * @param  array  $options
     * @return array
     */
    public static function get($table_id, $options = array())
    {
        return Curl_http::get("/table/{$table_id}", $options);
    }

    //更新表格
    public static function update($table_id, $attributes = array())
    {
        return Curl_http::put("/table/{$table_id}", $attributes);
    }

    /**
     * [copy 复制表格]
     * @param  [type] $table_id   [表格id]
     * @param  array  $attributes [description]
     * @return [type]             [description]
     */
    public static function copy($table_id, $attributes = array())
    {
        return Curl_http::post("/table/{$table_id}/copy", $attributes);
    }
    /**
     * [setAlias 取别名]
     * @param  [type] $table_id   [表格id]
     * @param  array  $attributes [description]
     * @return [type]             [description]
     */
    public static function setAlias($table_id, $attributes = array())
    {
        return Curl_http::post("/table/{$table_id}/alias", $attributes);
    }
    /**
     * get
     *
     * @param  integer $table_id
     * @param  array  $options
     * @return array
     */
    public static function getTables($space_id, $options = array())
    {
        return Curl_http::get("/tables/space/{$space_id}", $options);
    }

    //获取表格权限
    public static function getPermissions($table_id, $options = array())
    {
        return Curl_http::get("/permissions/table/{$table_id}", $options);
    }

    /**
     * get_alias_fields
     *
     * @param  array $table
     * @param  integer $app_id
     * @return
     */
    public static function get_alias_fields($table, $app_id)
    {

        $fields = array();
        if ($table && $table['fields']) {
            foreach ($table['fields'] as $key => $value) {

                if ($value['app_id'] != $app_id) {
                    continue;
                }
                $fields[$value['field_id']]          = $value;
                $fields[$value['application_alias']] = $value;
            }
        }

        return $fields;
    }
}
