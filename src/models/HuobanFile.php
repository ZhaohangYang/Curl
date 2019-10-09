<?php

namespace Huoban\Models;
use Huoban\Helpers\CurlHttp;

class HuobanFile {

    public static function upload($file_path, $file_name, $type = 'attachment') {

        return CurlHttp::post('/file', array('source' => realpath($file_path), 'name' => $file_name, 'type' => $type), array('upload' => TRUE));
    }
}
