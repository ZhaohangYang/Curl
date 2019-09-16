<?php
namespace huoban\models;

use huoban\models\HuobanShare;
use huoban\helpers\Curl_http;

class HuobanTicket {

    /**
     * create
     *
     * @param  array  $attributes
     * @return
     */
    public static function create($attributes = array()) {
        return Curl_http::post("/ticket", $attributes);
    }
    
    /**
    * 解析ticket
    * @author       ldchao
    * @date         2016.12.13
    */
    public static function parse() {
        return Curl_http::get('/ticket/parse');
    }
    
    /**
    * 从Stroage中获取ticket
    * @author       ldchao
    * @date         2016.12.19
    */
    public static function getTicket($table_id, $app_id) {
        
        $cache_key = 'share_ticket';
        $ticket_time = HuobanStorage::get($cache_key);
        $ticket_time = explode(':', $ticket_time['value']);
        
        //默认1209600 14天,10天更新一次
        if(empty($ticket_time[0]) || (time() - $ticket_time[1] >= 864000)) {

            $share = HuobanShare::getShare($table_id);
            $ticket = HuobanTicket::create(array('app_id'=>$app_id,'share_id'=>$share['share_id'],'secret'=>$share['secret']));      
            
            $str = $ticket['ticket'].':'.time();
            $ticket_time = explode(':', $str);
            HuobanStorage::set($cache_key, $str);
        }

        return $ticket_time[0];  
    }
}
