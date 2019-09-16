<?php
namespace huoban\models;
use huoban\helpers\Curl_http;
use huoban\models\HuobanStorage;

class HuobanWechat {
    
    public static function code($appid, $url, $scope = 'snsapi_base') { 
        $url = urlencode($url);
        header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$url&response_type=code&scope=$scope#wechat_redirect");die();         
    }
    
    public static function openid($appid, $secret, $code) {        
        return Curl_http::get('https://api.weixin.qq.com/sns/oauth2/access_token', array('appid' => $appid, 'secret'=>$secret, 'code'=>$code, 'grant_type'=>'authorization_code'), array('pass_version'=>true));              
    }
    
    public static function access_token($appid, $secret) {
        
        $token_time = HuobanStorage::get('access_token');
        $token_time = explode(':', $token_time['value']);
        
        if(empty($token_time[0]) || (time() - $token_time[1] >= 5400)) {
            
            $res = Curl_http::get('https://api.weixin.qq.com/cgi-bin/token', array('appid' => $appid, 'secret'=>$secret, 'grant_type'=>'client_credential'), array('pass_version'=>true));            
            $str = $res['access_token'].':'.time();
            $token_time = explode(':', $str);
            HuobanStorage::set('access_token', $str);
        }
        
        return $token_time[0];             
    }
    
    public static function jsapi_ticket($access_token) {
        
        $ticket_time = HuobanStorage::get('jsapi_ticket');
        $ticket_time = explode(':', $ticket_time['value']);
        
        if(empty($ticket_time[0]) || (time() - $ticket_time[1] >= 5400)) {
            
            $res = Curl_http::get('https://api.weixin.qq.com/cgi-bin/ticket/getticket', array('access_token' => $access_token, 'type'=>'jsapi'), array('pass_version'=>true));            
            $str = $res['ticket'].':'.time();
            $ticket_time = explode(':', $str);
            HuobanStorage::set('jsapi_ticket', $str);
        }
        
        return $ticket_time[0];       
    }    
    
    public static function sign($data = array(), $type = 'sha1', $key = '') {
        
        ksort($data);
        $convert = array();
        $res = '';
        
        foreach($data as $k=>$v) {
            $convert[] = $k.'='.$v;
        }
        
        if(!empty($key)) {
            $convert[] = 'key='.$key;
        }
        
        if($type == 'sha1') {
            $res = sha1(join('&', $convert));
        } else if($type == 'md5') {
            $res = strtoupper(md5(join('&', $convert)));
        }
        
        return $res;
    }

}