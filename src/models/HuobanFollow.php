<?php
namespace huoban\models;
use huoban\helpers\CurlHttp;

class HuobanFollow {

    public static function create($item_id) {
        return CurlHttp::post("/follow/item/{$item_id}");
    }

    public static function delete($ref_id) {
        return CurlHttp::delete("/follow/item/{$ref_id}");
    }

    public static function getAll($item_id, $attributes = array()) {
        return CurlHttp::post("/follow/item/{$item_id}/find", $attributes);
    }
}