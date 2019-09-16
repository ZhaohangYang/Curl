<?php
namespace huoban\models;
use huoban\helpers\CurlHttp;

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
        return CurlHttp::get("/storage", $attributes, $options);
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
        return CurlHttp::post("/storage", $attributes, $options);
    }
}
