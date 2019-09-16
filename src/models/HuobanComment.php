<?php

namespace huoban\models;
use huoban\helpers\Curl_http;


class HuobanComment {
    
    public static function create($item_id, $attributes = array()) {
        return Curl_http::post("/comment/item/{$item_id}", $attributes);
    }

    public static function delete($comment_id) {
        return Curl_http::delete("/comment/{$comment_id}");
    }

    public static function get_all($item_id, $attributes = array()) {
        return Curl_http::get("/comments/item/{$item_id}", $attributes);
    }
}