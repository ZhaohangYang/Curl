<?php
namespace huoban\models;
use huoban\helpers\Curl_http;

class HuobanStream {

    /**
     * 获取item动态
     * $attributes = array(
     *     'limit' => 10,
     *     'last_stream_id' => 11001,
     * );
     */
    public static function get_for_item($item_id, $attributes = array()) {
        return Curl_http::get("/streams/item/{$item_id}", $attributes);
    }

}