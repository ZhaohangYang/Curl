<?php
namespace huoban\models;
use huoban\helpers\CurlHttp;

class HuobanSpace {

    /**
     * 获取工作区的支付信息接口
     *
     * @param  integer $table_id
     * @param  array  $options
     * @return array
     */
    public static function payInfo($space_id, $params = array(), $opts = array()) {
        return CurlHttp::get("/space/{$space_id}/pay_info", $params, $opts);
    }
    
    /**
     * 获取工作区的支付方式接口
     *
     * @param  integer $table_id
     * @param  array  $options
     * @return array
     */
    public static function paymentInfo($space_id, $params = array(), $opts = array()) {
        return CurlHttp::get("/space/{$space_id}/payment_info", $params, $opts);
    }
    
    //获取所有工作区
    public static function getJoined() {
        return CurlHttp::get('/spaces/joined');
    }
    
    //获取工作区
    public static function get($space_id, $opts = array('pass_version' => true)) {
        return CurlHttp::get("/space/{$space_id}",$opts);
    }
}