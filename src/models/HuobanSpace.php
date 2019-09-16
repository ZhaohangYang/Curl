<?php
namespace huoban\models;
use huoban\helpers\Curl_http;

class HuobanSpace {

    /**
     * 获取工作区的支付信息接口
     *
     * @param  integer $table_id
     * @param  array  $options
     * @return array
     */
    public static function pay_info($space_id, $params = array(), $opts = array()) {
        return Curl_http::get("/space/{$space_id}/pay_info", $params, $opts);
    }
    
    /**
     * 获取工作区的支付方式接口
     *
     * @param  integer $table_id
     * @param  array  $options
     * @return array
     */
    public static function payment_info($space_id, $params = array(), $opts = array()) {
        return Curl_http::get("/space/{$space_id}/payment_info", $params, $opts);
    }
    
    //获取所有工作区
    public static function getJoined() {
        return Curl_http::get('/spaces/joined');
    }
    
    //获取工作区
    public static function get($space_id, $opts = array('pass_version' => true)) {
        return Curl_http::get("/space/{$space_id}",$opts);
    }
}