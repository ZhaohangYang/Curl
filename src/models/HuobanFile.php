<?php

namespace huoban\models;
use huoban\helpers\Curl_http;

class HuobanFile {

    public static function upload($file_path, $file_name, $type = 'attachment') {

        return Curl_http::post('/file', array('source' => realpath($file_path), 'name' => $file_name, 'type' => $type), array('upload' => TRUE));
    }
}
