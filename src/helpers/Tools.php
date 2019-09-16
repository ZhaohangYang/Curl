<?php

namespace huoban\helpers;

use huoban\models\HuobanItem;

/**
 * [Tools.php]
 * @Author   zhaohangyang (zhaohangyang@comsenz-service.com)
 * @DateTime 2019-01-07 15:08:10
 */
class Tools
{

    public static function p($data, $die = false)
    {
        echo '<meta charset="utf-8" /><pre>';
        if (!empty($data)) {
            print_r($data);
        } else {
            var_dump($data);
        }
        if ($die) {
            exit();
        }
    }

    /**
     * [keyConvert 二维数组某个key值作为一维键值]
     * @param  [arr] $arr  [要格式化的数组]
     * @param  string $key [要作为key的键值名]
     * @return [arr]       [格式好的数据]
     */
    public static function keyConvert($arr, $key = '')
    {
        $new_arr = array();
        if (empty($arr)) {
            return $new_arr;
        }
        foreach ($arr as $k => $v) {
            $new_arr[$v[$key]] = $v;
        }
        return $new_arr;
    }

    /**
     * [returnDiy 判断类型 返回值]
     * @param  [arr] $item  [云表格数据]
     * @param  [arr] $table [云表格的表格结构数组]
     * @param  array  $rule [期望返回的值得名称 默认是各个字段的显示值]
     * @return [arr]        [格式化好的数据]
     */
    public static function returnDiy(&$item, $rule = [])
    {
        $data = [];
        foreach ($item['fields'] as $field_data) {
            $alias = $field_data['alias'];
            $data[$alias] = $field_data;
        }
        $data['item_id'] = $item['item_id'];
        return $data;
    }

    /**
     * [getAllItems 获取指定条件下的全部信息;慎用此函数全部返回,数据量大可能影响执行效率]
     * @param  [arr]  &$table       [云表格的表格结构数组]
     * @param  [arr]  &$attributes  [筛选条件]
     * @param  integer $limit       [每次查询的上限默认最大值500]
     * @param  integer $offset      [每次查询的起始值]
     * @return [arr]                [查询结果]
     */
    public static function getAllItems(&$data, &$table, &$attributes, $limit = 500, $offset = 0)
    {
        $attributes['limit']  = $limit;
        $attributes['offset'] = $offset;

        $data_tmp = HuobanItem::find($table['table_id'], $attributes);

        if (isset($data_tmp['code'])) {
            throw new \Exception($data_tmp['message'], '200001');
        }
        if ($data_tmp['filtered'] <= 0) {
            return false;
        }

        if (count($data_tmp['items']) >= $limit) {
            self::getAllItems($data, $table, $attributes, $limit, $offset + $limit);
        }

        foreach ($data_tmp['items'] as $key => $item) {
            $data['items'][] = self::returnDiy($item);
        }
        $data['filtered'] = $data_tmp['filtered'];
        $data['total']    = $data_tmp['total'];
    }

    /**
     * [getItems 获取指定条件下的全部信息;]
     * @param  [arr]  &$table       [云表格的表格结构数组]
     * @param  [arr]  &$attributes  [筛选条件]
     * @param  integer $limit       [每次查询的上限默认最大值500]
     * @param  integer $offset      [每次查询的起始值]
     * @return [arr]                [查询结果]
     */
    public static function getItems(&$table, &$attributes)
    {
        $data = HuobanItem::find($table['table_id'], $attributes);
        if (isset($data['code'])) {
            throw new \Exception($data['message'], '200001');
        }
        if ($data['filtered'] <= 0) {
            return $data;
        }
        $data['items'] = Tools::formatItems($table, $data['items']);
        return $data;
    }

    /**
     * [formatItems 格式化云表格信息多条]
     * @param  [arr] $table [数据对应的云表格表格结构]
     * @param  [arr] $items [要格式化的云表格数据]
     * @return [arr]        [格式化的数据]
     */
    public static function formatItems($table, $items)
    {
        $data = [];
        if ($items && count($items) > 0) {
            foreach ($items as $item) {
                $data[] = self::returnDiy($item);
            }
        }

        return $data;
    }
}
