<?php
namespace huoban\models;
use huoban\helpers\Curl_http;

class HuobanStorage {

    /**
     * get
     *
     * @return array
     */
    public static function get($key, $options = array()) {
        $attributes = array(
            'key' => $key,
        );
        return Curl_http::get("/storage", $attributes, $options);
    }

    /**
     * set
     *
     * @return array
     */
    public static function set($key, $value, $options = array()) {
        $attributes = array(
            'key' => $key,
            'value' => $value,
        );
        return Curl_http::post("/storage", $attributes, $options);
    }
}
