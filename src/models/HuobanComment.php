<?php

namespace huoban\models;
use huoban\helpers\CurlHttp;


class HuobanComment {
    
    public static function create($item_id, $attributes = array()) {
        return CurlHttp::post("/comment/item/{$item_id}", $attributes);
    }

    public static function delete($comment_id) {
        return CurlHttp::delete("/comment/{$comment_id}");
    }

    public static function getAll($item_id, $attributes = array()) {
        return CurlHttp::get("/comments/item/{$item_id}", $attributes);
    }
}