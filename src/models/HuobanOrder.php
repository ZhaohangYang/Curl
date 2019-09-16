<?php
namespace huoban\models;
use huoban\helpers\Curl_http;

class HuobanOrder {

    public static function create($attributes = array()) {
        return Curl_http::post("/pay_order", $attributes);
    }
    
    public static function order($order_no) {
        return Curl_http::get("/pay_order/$order_no");
    }
    
}