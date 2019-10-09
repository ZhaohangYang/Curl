<?php

namespace Huoban\Models;

use Huoban\Helpers\CurlHttp;

class HuobanItem
{

    public static function stats($table_id, $attributes = array(), $options = array())
    {
        return CurlHttp::post("/item/table/{$table_id}/stats", $attributes, $options);
    }
    //创建数据
    public static function create($table_id, $attributes = array())
    {
        return CurlHttp::post("/item/table/{$table_id}", $attributes);
    }

    //批量创建数据（云表格信息最大200左右）
    public static function creates($table_id, $attributes = array())
    {
        return CurlHttp::post("/item/table/{$table_id}/create", $attributes);
    }

    //批量删除数据
    public static function dels($table_id, $attributes = array())
    {
        return CurlHttp::post("/item/table/{$table_id}/delete", $attributes);
    }

    public static function get($item_id, $options = array())
    {
        return CurlHttp::get("/item/{$item_id}", array(), $options);
    }

    public static function update($item_id, $attributes = array())
    {
        return CurlHttp::put("/item/{$item_id}", $attributes);
    }

    public static function updates($table_id, $attributes = array(), $options = array())
    {
        return CurlHttp::post("/item/table/{$table_id}/update", $attributes, $options);
    }

    public static function delete($item_id)
    {
        return CurlHttp::delete("/item/{$item_id}");
    }
    //关联数据
    public static function field($field_id, $attributes = array(), $options = array())
    {
        return CurlHttp::post("/item/field/{$field_id}/search", $attributes, $options);
    }
    //查询数据
    public static function find($table_id, $attributes = array(), $options = array())
    {
        return CurlHttp::post("/item/table/{$table_id}/find", $attributes, $options);
    }

    /**
     * 原始数据比较麻烦，减少代码，封装不层
     * @author   ldchao
     * @date     2017.7.6
     */
    public static function search(&$table, $params, $limit = 500, $offset = 0, $order_by = [])
    {
        $attr = [
            'where' => ['and' => []],
            'limit' => $limit,
            'offset' => $offset,
            //'order_by' => []
        ];

        foreach ($params as $k => $v) {
            $attr['where']['and'][] = ['field' => $table[$k], 'query' => $v];
        }

        foreach ($order_by as $k => $v) {
            $attr['order_by'][] = ['field' => $table[$k], 'sort' => $v];
        }
        return self::find($table['table_id'], $attr);
    }

    public static function find_by_item_ids($table_id, $item_ids)
    {
        $where = array(
            'and' => array(),
        );

        $where['and'][] = array(
            'field' => 'item_id',
            'query' => array(
                'in' => $item_ids,
            ),
        );

        $attributes = array(
            'where' => $where,
            'limit' => 500,
        );
        return self::find($table_id, $attributes);
    }
}
