<?php
require_once __DIR__ . "/vendor/autoload.php";

use huoban\models\HuobanItem;
use huoban\helpers\Tools;
use huoban\models\HuobanApplication;

defined('IS_TEST') or define('IS_TEST', false);

HuobanApplication::setTicket();

$res = HuobanItem::get('2300001282173559');

var_dump($res);exit;