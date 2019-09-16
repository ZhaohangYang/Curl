<?php
namespace huoban\models;
use huoban\helpers\Curl_http;

class HuobanFollow {

    public static function create($item_id) {
        return Curl_http::post("/follow/item/{$item_id}");
    }

    public static function delete($ref_id) {
        return Curl_http::delete("/follow/item/{$ref_id}");
    }

    public static function get_all($item_id, $attributes = array()) {
        return Curl_http::post("/follow/item/{$item_id}/find", $attributes);
    }
}