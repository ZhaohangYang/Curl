<?php
require_once __DIR__ . "/vendor/autoload.php";

use Huoban\Models\HuobanItem;
use Huoban\Helpers\Tools;
use Huoban\Models\HuobanApplication;

defined('IS_TEST') or define('IS_TEST', false);

$ticket = HuobanApplication::getEnterpriseTicket('1000307','GkCtOwFXsr1Sqsne6TNi0gMmwHZxKqTn9AzLyuEw');
HuobanApplication::setTicket($ticket);

$res = HuobanItem::get('2300001282173559');
var_dump($res);
