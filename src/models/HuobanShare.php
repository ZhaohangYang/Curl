<?php

namespace huoban\models;
use huoban\helpers\Curl_http;


class HuobanShare {

    public static function get($ref_type,$ref_id, $attributes = array()) {
        return Curl_http::post("/share/{$ref_type}/{$ref_id}", $attributes);
    }
    
    public static function getShare($table_id, $is_new = false) {
        
        $share = HuobanStorage::get('share');     
        
        if($is_new || empty($share['value'])) {
            $share = self::get('table', $table_id);
            HuobanStorage::set('share', $share);
        } else {
            $share = $share['value'];
        }
        
        return $share;        
    }
}