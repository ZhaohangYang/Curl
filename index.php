<?php
require_once __DIR__ . "/vendor/autoload.php";

use Zhaohangyang\Curl\Curl;


$res = Curl::get('www.baidu.com');

print_r($res);
exit;
