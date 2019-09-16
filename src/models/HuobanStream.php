<?php
namespace huoban\models;
use huoban\helpers\CurlHttp;

class HuobanStream {

    /**
     * 获取item动态
     * $attributes = array(
     *     'limit' => 10,
     *     'last_stream_id' => 11001,
     * );
     */
    public static function getForItem($item_id, $attributes = array()) {
        return CurlHttp::get("/streams/item/{$item_id}", $attributes);
    }

}